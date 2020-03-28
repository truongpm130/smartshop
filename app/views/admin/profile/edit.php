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

                <a href="<?php echo URLROOT; ?>/admin/profile/<?php echo $data['user']->id; ?>" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Update Profile -->
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo $data['user']->photo_id ? URLROOT . '/images/users/' . $data['photo'] : AVATAR ?>" alt="..." class="img-fluid rounded-circle p-2">
                        <div class="text-center mt-3">
                            <form action="<?php echo URLROOT; ?>/photos/updateAvatar/<?php echo $data['user']->id ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for='file'>Change your avatar</label>
                                    <input type="file" name="file">
                                    <span class="text-small text-danger"><?php echo isset($data['file_err']) ? $data['file_err'] : ''; ?></span>
                                </div>
                                
                                <input type="submit" value="Save avatar" class="btn btn-success btn-block" name="update_file">
                            </form>                            
                        </div>                        
                    </div>
                    <div class="col-md-8">
                        <form action="<?php echo URLROOT; ?>/users/profileUpdate/<?php echo $data['user']->id; ?>" method="post">   
                            <div class="row">
                                <div class="form-group col">
                                    <label for="first_name">Tên: </label>
                                    <input type="text" name="first_name" id="" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->first_name; ?>">
                                    <span class="invalid-feedback"><?php echo $data['first_name_err']; ?></span>
                                </div>
                                <div class="form-group col">
                                    <label for="last_name">Họ: </label>
                                    <input type="text" name="last_name" id="" class="form-control <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->last_name; ?>">
                                    <span class="invalid-feedback"><?php echo $data['last_name_err']; ?></span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Email: </label>
                                <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $data['user']->email; ?>">
                                </div>
                            </div>

                            <input type="submit" value="Cập nhật" class="btn btn-primary btn-block">
                        </form>

                    <div class="mt-5">
                        <a href="<?php echo URLROOT; ?>/users/changePass/<?php echo $data['user']->id; ?>" class="btn btn-warning">Change Password</a>
                    </div>
                        

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>