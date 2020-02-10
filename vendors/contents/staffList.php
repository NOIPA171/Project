
<input type="text" class="form-control form-control-sm m-b-xs" id="mysqlFilter" placeholder="搜尋"> <br>
<!-- <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table"> -->

<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter id="edit-table">
    <thead>
        <tr>
            <th>名稱</th>
            <th>Email</th>
            <th data-hide="phone">身份</th>
            <th data-hide="phone, tablet">帳號</th>
            <th data-hide="phone">狀態</th>
            <th data-sortable="false"></th>
            <th data-hide="all">擁有權限</th>
            <th data-hide="all">備註</th>
            <th data-hide="all">ID</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // get admin count for vendor
        $sql = "SELECT `vendorAdmins`.`vaId`, `vaFName`, `vaLName`, `vaEmail`, `vaActive`, `vaVerify`, `vaNotes`, `vaRoleId`,
        `vId`, `vaLoginTime`, `vaLogoutTime`
                FROM `vendorAdmins`
                WHERE `vId` = ?";

        $stmt = $pdo->prepare($sql);
        $arrParam = [ $arrGetInfo['vId'] ];
        $stmt->execute($arrParam);
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //取得個別人的資訊
            $sqlPermissions = "SELECT `vendorPermissions`.`vendorPrmName`
                                FROM `rel_vendor_permissions`
                                INNER JOIN `vendorPermissions`
                                ON `rel_vendor_permissions`.`vaPermissionId` = `vendorPermissions`.`vendorPrmId`
                                WHERE `vaId` = ?";
            $stmtPermissions = $pdo->prepare($sqlPermissions);
            //每一個人執行一次尋找其permission
            for($i = 0 ; $i<count($arr); $i++){
                //先初始化permissions
                $prmList = [];
                $arrParamPermissions = [ $arr[$i]['vaId'] ];
                $stmtPermissions->execute($arrParamPermissions);

                if($stmtPermissions->rowCount()>0){
                    //撈出所有permission，並用兩層foreach去除多餘的上一層
                    $arrPermissions = $stmtPermissions->fetchAll(PDO::FETCH_ASSOC);
                    foreach($arrPermissions as $key => $value){
                        foreach($value as $k => $v){
                            $prmList[] = $v;
                        }
                    }
                    //把permission輸入到admin裡
                    $arr[$i]['permissions'] = $prmList;
                    
                    if($arr[$i]['vaRoleId']==1){
                        $arr[$i]['identity'] = "Owner";
                    }else if($arr[$i]['vaRoleId']==2){
                        $arr[$i]['identity'] = "Manager";
                    }else{
                        $arr[$i]['identity'] = "Staff";
                    }
                }
            }
            
            for($i = 0 ; $i<count($arr); $i++){
                //不顯示自己的資料
                if($arr[$i]['vaId']==$arrGetInfo['vaId']){
                    continue;
                }else{
                ?>
                <tr id="vaId<?php echo $arr[$i]['vaId'] ?>">
                    <td><?php echo $arr[$i]['vaFName'].' '.$arr[$i]['vaLName'] ?></td>
                    <td><?php echo $arr[$i]['vaEmail'] ?></td>
                    <td><?php echo $arr[$i]['identity'] ?></td>
                    <td><?php echo $arr[$i]['vaActive'] ?></td>
                    <td>
                        <?php 
                        if($arr[$i]['vaRoleId']== 1){
                            echo "";
                        }else if($arr[$i]['vaLogoutTime'] !== null){
                            $login = new DateTime($arr[$i]['vaLoginTime']);
                            $logout = new DateTime($arr[$i]['vaLogoutTime']);
                            
                            $ifOnline = $logout->diff($login);

                            if($ifOnline->invert === 0){
                                echo "線上";
                            }else{
                                $timeDiff = $logout->diff(new DateTime());
                                if($ifOnline->d > 0){
                                    echo $timeDiff->days." 天前";
                                }else if($timeDiff->h >0){
                                    echo $timeDiff->h." 小時前";
                                }else if($timeDiff->i > 0){
                                    echo $timeDiff->i." 分鐘前";
                                }else{
                                    echo $timeDiff->s." 秒前";
                                }
                            }
                        }else if($arr[$i]['vaActive']==='inactive'){
                            echo "帳號尚未啟用";
                        }elseif($arr[$i]['vaActive']!=='inactive' && $arr[$i]['vaLogoutTime'] === null && $arr[$i]['vaLoginTime'] === null){
                            echo "未登入過";
                        }else{
                            echo "線上";
                        }
                        
                        ?>
                    </td>
                    <td>
                    <?php 
                    if($arr[$i]['vaRoleId']==1){
                        continue;
                    }else{
                    ?>
                        <div class="float-right mr-2 mr-md-0"  style="font-size: 1.2rem">
                            <a data-toggle="modal" data-target="#editor-modal" data-func="edit" data-id="<?php echo $arr[$i]['vaId']; ?>"><i class="fa fa-edit text-navy mr-2 mr-md-0"></i></a>
                            <a data-func="delete" href="#" data-id="<?php echo $arr[$i]['vaId']; ?>"><i class="fa fa-trash text-navy mr-2 mr-md-0"></i></a>
                        </div>
                    <?php
                    }
                    ?>
                    </td>
                    <td><?php echo implode(', ', $arr[$i]['permissions']) ?></td>
                    <td><?php echo $arr[$i]['vaNotes'] ?></td>
                    <td><?php echo $arr[$i]['vaId'] ?></td>
                </tr>
                <?php
                }
            }
        }

    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <ul class="pagination float-right"></ul>
            </td>
        </tr>
    </tfoot>
</table>


<div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">
	<div class="modal-dialog" role="document">
		<form class="modal-content form-horizontal" id="editor" action="./check_staff_edit.php" method="post">
			<div class="modal-header">
                <h4 class="modal-title" id="editor-title">
                編輯
                <span></span>
                </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
                <div class="form-group">
					<label for="startedOn" class="col-sm-3 control-label">帳號狀態</label>
					<div class="col-sm-12">
						<select name="active" id="active" class="form-control">
                            <option value="active">啟用</option>
                            <option value="inactive">停用</option>
                        </select>
					</div>
				</div>
                <div class="form-group">
                    <div class="col-sm-12" id="permissions">
                        <div class="row" id="title">
                            <div class="col-sm-6">
                                <div class="i-checks mt-2">
                                    <label id="staff"> 
                                        <input type="radio" value="3" name="title" checked> 
                                        <i></i> 賦予工作人員權限 
                                        <small class="text-muted"></small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="i-checks mt-2">
                                    <label id="manager"> 
                                        <input type="radio" value="2" name="title"> 
                                        <i></i> 賦予管理員權限 <br>
                                        <small class="text-muted" style="margin-left: 1.6rem;">管理所有頁面（包含帳號管理）</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div id="edit_permissions">
                            <label class="col-form-label mb-2">編輯權限</label>
                            <div class="i-checks">
                                <label> <input type="checkbox" value="products" checked="" name="staffPrm[]"> 
                                <i></i> 產品 </label>
                            </div>
                            <div class="i-checks">
                                <label> <input type="checkbox" value="charts" checked="" name="staffPrm[]"> 
                                <i></i> 報表 </label>
                            </div>
                            <div class="i-checks">
                                <label> <input type="checkbox" value="marketing" checked="" name="staffPrm[]"> 
                                <i></i> 行銷 </label>
                            </div>
                            <div class="i-checks">
                                <label> <input type="checkbox" value="orders" checked="" name="staffPrm[]"> 
                                <i></i> 訂單 </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="startedOn" class="col-sm-3 control-label">備註</label>
                    <div class="col-sm-12">
                        <textarea name="notes" cols="30" rows="10" id="noteText"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" value="" name="vaId" id="id">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</form>
	</div>
</div>