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

                <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Update Profile -->

                <div class="row">
                    <div class="ml-auto">
                        <a href="<?php echo URLROOT; ?>/users/changePass/<?php echo $data['user']->id; ?>" class="btn btn-warning">Change Password</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="
                  <?php
                        if (!empty($data['user']->photo_id)) {
                            echo URLROOT . '/images/users/' . $data['photo'];
                        } elseif ($data['user']->gender == 2) {
                            echo AVATAR_FEMALE;
                        } else {
                            echo AVATAR_MALE;
                        }
                        ?>
                  " alt="..." class="img-fluid rounded-circle w-75 p-3">
                        <div class="text-center mt-3">
                            <form action="<?php echo URLROOT; ?>/users/updateAvatar/<?php echo $data['user']->id ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for='file'>Change your avatar</label>
                                    <input type="file" name="file">

                                    <?php if(!empty($data['file_err'])) :?>
                                    <?php foreach($data['file_err'] as $msg) :?>
                                    <span class="text-small text-danger"><?php echo $msg . '<br>'; ?></span>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <input type="submit" value="Save avatar" class="btn btn-success btn-block" name="update_file">
                            </form>                            
                        </div>                        
                    </div>
                    <div class="col-md-8 mt-4">
                        <form action="<?php echo URLROOT; ?>/users/profileUpdate/<?php echo $data['user']->id; ?>" method="post">   
                            <div class="row">
                                <div class="form-group col">
                                    <label for="first_name">First Name: </label>
                                    <input type="text" name="first_name" id="" class="form-control <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->first_name; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['first_name_err'];?></span>
                                </div>
                                <div class="form-group col">
                                    <label for="last_name"></label>Last Name: </label>
                                    <input type="text" name="last_name" id="" class="form-control <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->last_name; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['last_name_err']; ?></span>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Email: </label>
                                <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $data['user']->email; ?>">
                                </div>
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

                            <div class="form-group my-4">
                                <label for="phone">Phone number: </label>
                                <input type="text" name="phone" id="" class="form-control <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->phone; ?>">
                                <span class="invalid-feedback"><?php echo $data['phone_err'];?></span>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary btn-block mt-5">
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>