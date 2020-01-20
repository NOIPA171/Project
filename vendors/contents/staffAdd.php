<form method="post" action="./check_staff_add.php">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            基本資訊 <br>
            <small class="text-muted">寄信邀請新人員一起管理您的後台。</small>
            <br>
            <small class="text-warning mt-2 d-block" id="message"></small>
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6 m-b"><input type="text" name="Lname" placeholder="姓 *" class="form-control" required></div>
                <div class="col-sm-6 m-b"><input type="text" name="Fname" placeholder="名 *" class="form-control" required></div>
                <div class="col-md-12 m-b"><input type="email" name ="email" placeholder="Email *" class="form-control" required></div>
                <div class="col-md-12 m-b"><input type="text" name ="notes" placeholder="備註" class="form-control"></div>  
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="i-checks mt-2">
                                <label id="staff"> 
                                    <input type="radio" value="staff" name="title" checked> 
                                    <i></i> 賦予工作人員權限 
                                    <small class="text-muted"></small>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="i-checks mt-2">
                                <label id="owner"> 
                                    <input type="radio" value="owner" name="title"> 
                                    <i></i> 賦予管理員權限 <br>
                                    <small class="text-muted" style="margin-left: 1.6rem;">管理所有頁面（包含帳號管理）</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="edit_permissions">
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
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-primary btn-sm" type="submit">寄送邀請</button>
        </div>
    </div>
</form>