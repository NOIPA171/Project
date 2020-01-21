<?php

$vendorInfo = $pdo->query("SELECT `vEmail`, `vInfo`, `vImg`, `vName` FROM `vendors` WHERE `vId` = '{$arrGetInfo['vId']}'")->fetch(PDO::FETCH_ASSOC);

?>

<form method="post" action="./check_my_accountV.php" enctype='multipart/form-data'>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            公司Logo <br>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b">
                    <img src="./images/<?php echo $vendorInfo['vImg'] ?>" alt="" class="logoUpdate">
                    <input type="file" name="vImg">
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            公司名稱 <br>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b">
                    <input type="text" name="vName" placeholder="姓 *" class="form-control" required value="<?php echo $vendorInfo['vName'] ?>">
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            Email <br>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b">
                    <input type="email" name ="vEmail" placeholder="Email *" class="form-control" required value="<?php echo $vendorInfo['vEmail'] ?>">
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            公司資訊 <br>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b">
                    <textarea name="vInfo" id="" cols="40" rows="5"><?php echo $vendorInfo['vInfo'] ?></textarea>
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
                        <button class="btn btn-w-m btn-default" type="button">更改密碼</button>
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