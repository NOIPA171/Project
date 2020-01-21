<form method="post" action="./check_my_account.php">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            基本資訊 <br>
            <!-- <small class="text-muted">寄信邀請新人員一起管理您的後台。</small> -->
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b">
                    <input type="text" name="Lname" placeholder="姓 *" class="form-control" required value="<?php echo $arrGetInfo['aLName'] ?>">
                </div>
                <div class="col-sm-6 m-b">
                    <input type="text" name="Fname" placeholder="名 *" class="form-control" required value="<?php echo $arrGetInfo['aFName'] ?>">
                </div>
                <div class="col-md-12 m-b">
                    <input type="email" name ="email" placeholder="Email *" class="form-control" required value="<?php echo $arrGetInfo['aEmail'] ?>">
                </div>
                <div class="col-md-12 m-b">
                    <input type="text" name ="notes" placeholder="備註" class="form-control" value="<?php echo $arrGetInfo['aNotes'] ?>">
                </div>  
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            安全資訊 <br>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-md-4 m-b">
                    <a href="./my_account_password.php">
                        <button id="changepwd" class="btn btn-w-m btn-default" type="button">更改密碼</button>
                    </a>
                </div>  
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-primary btn-sm" type="submit">更改</button>
        </div>
    </div>
    <div class="col-sm-6 mt-2">
        <small id="message" class="text-navy"></small>
    </div>
</form>