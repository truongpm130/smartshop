<!-- Header -->
<?php require_once APPROOT . '/views/includes/front_end/header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h4>SmartShop</h4>
                    <h5>Đăng ký tài khoản</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/users/register" method="post">
                        <div class="row">
                            <div class="form-group col">
                                <label for="first_name">Tên: </label>
                                <input type="text" name="first_name" id="" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>">
                                <span class="invalid-feedback"><?php echo $data['first_name_err'];?></span>
                            </div>
                            <div class="form-group col">
                                <label for="last_name">Họ: </label>
                                <input type="text" name="last_name" id="" class="form-control <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>">
                                <span class="invalid-feedback"><?php echo $data['last_name_err'];?></span>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="text" name="email" id="" class="form-control <?php echo (!empty($data['email_err']) ? 'is-invalid' : '')?>" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu: </label>
                            <input type="password" name="password" id="" class="form-control <?php echo (!empty($data['password_err']) ? 'is-invalid' : '')?>">
                            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Xác nhận mật khẩu: </label>
                            <input type="password" name="confirm_password" id="" class="form-control <?php echo (!empty($data['confirm_password_err']) ? 'is-invalid' : '')?> ">
                            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Đăng Ký" class="btn btn-primary btn-block">
                            </div>
                            <div class="col">
                                <button class="btn btn-light btn-block text-muted">Bạn đã có tài khoản?</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
</div>


<!-- Footer -->
<?php require_once APPROOT . '/views/includes/front_end/footer.php' ?>