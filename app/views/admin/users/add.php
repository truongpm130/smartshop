<!-- Header -->
<?php require_once APPROOT . '/views/includes/admin/header.php' ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once APPROOT . '/views/includes/admin/sidebar.php' ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once APPROOT . '/views/includes/admin/topbar.php' ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Users - Add</h1>
          <a href="<?php echo URLROOT; ?>/users/members" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

          <!-- Add User -->
            <form action="<?php echo URLROOT; ?>/users/add" method="post">
                <div class="row">
                    <div class="form-group col">
                        <label for="first_name">First Name: </label>
                        <input type="text" name="first_name" id="first_name" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>" required >
                        <span class="invalid-feedback" id="first_name_err"><?php echo $data['first_name_err']; ?></span>
                    </div>
                    <div class="form-group col">
                        <label for="last_name">Last Name: </label>
                        <input type="text" name="last_name" id="" class="form-control <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>" required>
                        <span class="invalid-feedback" id="last_name_err"><?php echo $data['last_name_err']; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" class="form-control <?php echo (!empty($data['email_err']) ? 'is-invalid' : '') ?>" value="<?php echo $data['email']; ?>" required >
                    <span class="invalid-feedback" id="email_err"><?php echo $data['email_err']; ?></span>
                </div>

                <div class="form-group">
                    <label for="gender" class="form-check-label mr-3">Gender:</label>
                    <?php if (!empty($data['genders'])) :?>
                        <?php foreach ($data['genders'] as $gender) :?>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="<?php echo $gender->name ?>" name="gender" value="<?php echo $gender->id ?>"
                                    <?php
                                    if (!empty($data['gender'])) {
                                        echo $data['gender'] == $gender->id ? 'checked' : '';
                                    }
                                    ?> required >
                                <label for="<?php echo $gender->name ?>" class="form-check-label"><?php echo ucfirst($gender->name); ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="birthday">Birthday: </label>
                    <input type="date" name="birthday" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>:
                    <select name="role" id="" class="form-control" required>
                        <option value="" selected>Select role</option>
                        <?php if($data['roles']) : ?>
                            <?php foreach($data['roles'] as $role) : ?>
                                <?php
                                if($role->id == $data['role']->roleId) {
                                    continue;
                                } ?>
                                <option value="<?php echo $role->id ?>"><?php echo ucfirst($role->name); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="psw" class="form-control <?php echo (!empty($data['password_err']) ? 'is-invalid' : '') ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at lest 6 characters" required >
                    <span class="invalid-feedback" id="pass_err"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password: </label>
                    <input type="password" name="confirm_password" id="conf_psw" class="form-control <?php echo (!empty($data['confirm_password_err']) ? 'is-invalid' : '') ?> " minlength="6" required>
                    <span class="invalid-feedback" id="confirm_pass_err"><?php echo $data['confirm_password_err']; ?></span>
                    <span id="conf_msg"></span>
                </div>

                <input type="submit" value="Create User" class="btn btn-primary btn-block" id="reg_btn">

            </form>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>

