<!-- Header -->
<?php require_once APPROOT . '/views/includes/front_end/header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h4>SmartShop</h4>
                    <h5>Register</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/users/register" method="post">
                        <div class="row">
                            <div class="form-group col">
                                <label for="first_name">First Name: </label>
                                <input type="text" name="first_name" id="first_name"
                                       class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>"
                                       value="<?php echo $data['first_name']; ?>" required>
                                <span class="invalid-feedback"
                                      id="first_name_err"><?php echo $data['first_name_err']; ?></span>
                            </div>
                            <div class="form-group col">
                                <label for="last_name">Last Name: </label>
                                <input type="text" name="last_name" id=""
                                       class="form-control <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>"
                                       value="<?php echo $data['last_name']; ?>" required>
                                <span class="invalid-feedback"
                                      id="last_name_err"><?php echo $data['last_name_err']; ?></span>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="text" name="email" id="email"
                                   class="form-control <?php echo(!empty($data['email_err']) ? 'is-invalid' : '') ?>"
                                   value="<?php echo $data['email']; ?>" required>
                            <span class="invalid-feedback" id="email_err"><?php echo $data['email_err']; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-check-label mr-3">Gender:</label>
                            <?php if (!empty($data['genders'])) : ?>
                                <?php foreach ($data['genders'] as $gender) : ?>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="<?php echo $gender->name ?>"
                                               name="gender" value="<?php echo $gender->id ?>"
                                            <?php
                                            if (!empty($data['gender'])) {
                                                echo $data['gender'] == $gender->id ? 'checked' : '';
                                            }
                                            ?> required>
                                        <label for="<?php echo $gender->name ?>"
                                               class="form-check-label"><?php echo ucfirst($gender->name); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday: </label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="psw"
                                   class="form-control <?php echo(!empty($data['password_err']) ? 'is-invalid' : '') ?>"
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                                   title="Password must contain at least one number, one uppercase and lowercase letter, and at lest 6 characters"
                                   required>
                            <span class="invalid-feedback" id="pass_err"><?php echo $data['password_err']; ?></span>
                        </div>
                        <div id="message">
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="length" class="invalid">Minimum <b>6 characters</b></p>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password: </label>
                            <input type="password" name="confirm_password" id="conf_psw"
                                   class="form-control <?php echo(!empty($data['confirm_password_err']) ? 'is-invalid' : '') ?> "
                                   minlength="6" required>
                            <span class="invalid-feedback"
                                  id="confirm_pass_err"><?php echo $data['confirm_password_err']; ?></span>
                            <span id="conf_msg"></span>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Register" class="btn btn-primary btn-block" id="reg_btn">
                            </div>
                            <div class="col">
                                <button class="btn btn-light btn-block text-muted">Already have an account?</button>
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