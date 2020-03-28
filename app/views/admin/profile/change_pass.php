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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Profile - Edit</h1>
                <a href="<?php echo URLROOT; ?>/users/profileUpdate/<?php echo $_SESSION['user_id']; ?>" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Update Profile -->
                <div class="row">
                    <div class="col-6 offset-3">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="password">Current Password: </label>
                                <input type="password" name="password" id="" class="form-control <?php echo $data['password_err'] ? 'is-invalid' : '' ?>">
                                <span class="invalid-feedback"> <?php echo $data['password_err'] ?></span>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password: </label>
                                <input type="password" name="new_password" id="" class="form-control <?php echo $data['new_password_err'] ? 'is-invalid' : '' ?>">
                                <span class="invalid-feedback"> <?php echo $data['new_password_err'] ?></span>
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Confirm New Password: </label>
                                <input type="password" name="confirm_new_password" id="" class="form-control <?php echo $data['confirm_new_password_err'] ? 'is-invalid' : '' ?>">
                                <span class="invalid-feedback"> <?php echo $data['confirm_new_password_err'] ?></span>
                            </div>
                            <input type="submit" value="Update Password" class="btn btn-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>