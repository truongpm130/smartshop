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

        <!-- Flash message -->
        <?php flash('message'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Profile</h1>
          <a href="<?php echo URLROOT; ?>/users/profileUpdate/<?php echo $data['user']->id ?>" class="btn btn-primary d-inline-block float-right"><i class="far fa-edit"></i> Edit Profile</a>

          <!-- Users Profile -->
          <div class="card mb-3">
              <div class="card-header p-3 text-center ">
                <h4 class="text-success"><?php echo $_SESSION['user_name'] ?></h4>
              </div>
              <div class="row no-gutters">
                <div class="col-md-4 mt-4 text-center">
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
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                  <p class="card-text my-2 ">Full Name: <strong><?php echo $data['user']->last_name . ' ' . $data['user']->first_name ?></strong></p>
                  <p class="card-text my-2">Email: <strong><?php echo $data['user']->email; ?></strong></p>
                  <p class="card-text my-2">Gender: <strong><?php echo ucfirst($data['gender']); ?></strong></p>
                  <p class="card-text my-2">Birthday: <strong><?php echo $data['user']->birthday; ?></strong></p>
                  <p class="card-text my-2">Phone: <strong><?php echo $data['user']->phone ?? ''; ?></strong></p>
                  <p class="card-text my-2">Join at:
                      <strong>
                          <?php
                            $date = $data['user']->created_at;
                            $date = strtotime($date);
                            echo  date('D, d/m/Y') ;
                          ?>
                      </strong></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>
