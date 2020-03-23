<!-- Header -->
<?php require_once APPROOT . '/views/includes/front_end/header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-6 offset-md-3">
            <!-- Flash message -->
            <?php flash('register_success'); ?>

            <!-- Login Form -->
            <div class="card">
                <div class="card-header text-center">
                    <h4>SmartShop</h4>
                    <h5>Đăng nhập</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/users/login" method="post">
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
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Đăng Nhập" class="btn btn-primary btn-block">
                            </div>
                            <div class="col">
                                <button class="btn btn-light btn-block text-muted">Bạn chưa có tài khoản?</button>
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