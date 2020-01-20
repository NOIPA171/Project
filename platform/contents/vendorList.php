

<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table">

<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter id="edit-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>廠商</th>
            <th>Email</th>
            <th>狀態</th>
            <th data-sortable="false"></th>
            <th data-hide="all">訊息</th>
            <th data-hide="all">工作人員</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // get admin count for vendor
        $sql = "SELECT `vId`, `vName`, `vEmail`, `vActive`, `vInfo`
                FROM `vendors`";

        $stmt = $pdo->query($sql);

        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //取得每個廠商的工作人員
            $sqladmins = "SELECT `vaFName`, `vaLName`, `vaEmail`, `vaActive`, `vaNotes`
                                FROM `vendorAdmins`
                                WHERE `vId` = ?";
            $stmtadmins = $pdo->prepare($sqladmins);
            for($i = 0 ; $i < count($arr) ; $i++){
                $arradmins = [ $arr[$i]['vId'] ];
                $stmtadmins->execute($arradmins);
            }
            if($stmtadmins->rowCount()>0){
                $arradmins = $stmtadmins->fetchAll(PDO::FETCH_ASSOC);
            }
            
            for($i = 0 ; $i<count($arr); $i++){
                ?>
                <tr>
                    <td><?php echo $arr[$i]['vId'] ?></td>
                    <td><?php echo $arr[$i]['vName'] ?></td>
                    <td><?php echo $arr[$i]['vEmail'] ?></td>
                    <td><?php echo $arr[$i]['vActive'] ?></td>
                    <td>
                        <div class="float-right mr-2 mr-md-0"  style="font-size: 1.2rem">
                            <a data-toggle="modal" data-target="#editor-modal" data-func="edit"><i class="fa fa-edit text-navy mr-2 mr-md-0"></i></a>
                            <a data-func="delete" href="./check/check_staff_delete.php?deleteId=<?php echo $arr[$i]['vId']; ?>"><i class="fa fa-trash text-navy mr-2 mr-md-0"></i></a>
                        </div>
                    </td>
                    <td><?php echo $arr[$i]['vInfo'] ?></td>
                    <td>
                        <table class="table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th>Email</th>
                                    <th>狀態</th>
                                    <th data-hide="all">備註</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($j = 0 ; $j < count($arradmins) ; $j++){
                                    ?>
                                    <tr>
                                        <td><?php echo $arradmins[$j]['vaLName'].' '.$arradmins[$j]['vaFName'] ?></td>
                                        <td><?php echo $arradmins[$j]['vaEmail'] ?></td>
                                        <td><?php echo $arradmins[$j]['vaActive'] ?></td>
                                        <td><?php echo $arradmins[$j]['vaNotes'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php
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
		<form class="modal-content form-horizontal" id="editor" action="./check/check_staff_edit.php" method="post">
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
                            <label> <input type="checkbox" value="products" name="staffPrm[]" id="products"> 
                            <i></i> 產品 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="charts" name="staffPrm[]" id="charts"> 
                            <i></i> 報表 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="marketing" name="staffPrm[]" id="marketing"> 
                            <i></i> 行銷 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="orders" name="staffPrm[]" id="orders"> 
                            <i></i> 訂單 </label>
                        </div>
                        <div class="i-checks">
                            <label> <input type="checkbox" value="admin" name="staffPrm[]" id="admin"> 
                            <i></i> 帳號  <small class="text-warning">此為後台管理員權限</small> </label>
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
            <input type="hidden" value="" name="vaId" id="id">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</form>
	</div>
</div>