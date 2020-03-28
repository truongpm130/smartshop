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
          <a href="<?php echo URLROOT; ?>/admin/members" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

          <!-- Add User -->
          <form action="<?php echo URLROOT; ?>/users/add" method="post">
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
                            <label for="role"> Vai trò</label>:                            
                            <select name="role" id="" class="form-control">
                                <option value=""></option>
                                <?php foreach($data['roles'] as $role) : ?>
                                <option value="<?php echo $role->id ?>"><?php echo $role->name ?></option>
                                <?php endforeach; ?>
                            </select> 
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
                        <input type="submit" value="Đăng Ký" class="btn btn-primary btn-block">
                    </form>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>

