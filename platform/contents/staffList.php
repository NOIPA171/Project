

<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table">

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
        // get admin count
        $sql = "SELECT `aId`, `aFName`, `aLName`, `aEmail`, `aActive`, `aVerify`, `aNotes`, `aLoginTime`, `aLogoutTime`
                FROM `platformAdmins`";

        $stmt = $pdo->query($sql);
        
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //取得個別人的權限
            $sqlPermissions = "SELECT `platformPermissions`.`adminPrmName`
                                FROM `rel_platform_permissions`
                                INNER JOIN `platformPermissions`
                                ON `rel_platform_permissions`.`aPermissionId` = `platformPermissions`.`adminPrmId`
                                WHERE `aId` = ?";
            $stmtPermissions = $pdo->prepare($sqlPermissions);

            //每一個人執行一次尋找其permission
            for($i = 0 ; $i<count($arr); $i++){

                //先初始化permissions
                $prmList = [];
                $arrParamPermissions = [ $arr[$i]['aId'] ];
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
                    
                    if(in_array('admin', $prmList)){
                        $arr[$i]['identity'] = "Owner";
                    }else{
                        $arr[$i]['identity'] = "Staff";
                    }
                }
            }
            
            for($i = 0 ; $i<count($arr); $i++){
                //不顯示自己的資料
                if($arr[$i]['aId']==$arrGetInfo['aId']){
                    continue;
                }else{
                ?>
                <tr>
                    <td><?php echo $arr[$i]['aFName'].' '.$arr[$i]['aLName'] ?></td>
                    <td><?php echo $arr[$i]['aEmail'] ?></td>
                    <td><?php echo $arr[$i]['identity'] ?></td>
                    <td><?php echo $arr[$i]['aActive'] ?></td>
                    <td>
                        <?php 
                        if($arr[$i]['aLogoutTime'] !== null){
                            $login = new DateTime($arr[$i]['aLoginTime']);
                            $logout = new DateTime($arr[$i]['aLogoutTime']);
                            
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
                        }else if($arr[$i]['aActive'] === 'inactive'){
                            echo "帳號尚未啟用";
                        }else if($arr[$i]['aActive'] !== 'inactive' && $arr[$i]['aLoginTime'] == null && $arr[$i]['aLogoutTime'] == null){
                            echo "未登入過";
                        }else{
                            echo "線上";
                        }
                        
                        ?>
                    </td>
                    <td>
                        <div class="float-right mr-2 mr-md-0"  style="font-size: 1.2rem">
                            <a data-toggle="modal" data-target="#editor-modal" data-func="edit"><i class="fa fa-edit text-navy mr-2 mr-md-0"></i></a>
                            <a data-func="delete" href="./check_staff_delete.php?deleteId=<?php echo $arr[$i]['aId']; ?>" data-id="<?php echo $arr[$i]['aId']; ?>"><i class="fa fa-trash text-navy mr-2 mr-md-0"></i></a>
                        </div>
                    </td>
                    <td><?php echo implode(', ', $arr[$i]['permissions']) ?></td>
                    <td><?php echo $arr[$i]['aNotes'] ?></td>
                    <td><?php echo $arr[$i]['aId'] ?></td>
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
                <h4 class="modal-title" id="editor-title">編輯</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
                <!-- <div class="form-row">
                    <div class="form-group required col-sm-6">
                        <label for="lastName" class="control-label">姓</label>
                        <input type="text" class="form-control" id="firstName" name="FName" placeholder="First Name" required>
                    </div>
                    <div class="form-group required col-sm-6">
                        <label for="firstName" class="control-label">名</label>
                        <input type="text" class="form-control" id="lastName" name="LName" placeholder="Last Name" required>
                    </div>
                </div> -->
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
                        <label class="col-form-label mb-2">編輯權限</label>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="vendors" name="staffPrm[]" id="products"> 
                            <i></i> 廠商 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="charts" name="staffPrm[]" id="charts"> 
                            <i></i> 報表 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="users" name="staffPrm[]" id="marketing"> 
                            <i></i> 會員 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="comments" name="staffPrm[]" id="orders"> 
                            <i></i> 評價 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="admin" name="staffPrm[]" id="admin"> 
                            <i></i> 工作人員  <small class="text-warning">此為後台管理員權限</small> </label>
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
            <input type="hidden" value="" name="aId" id="id">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</form>
	</div>
</div>