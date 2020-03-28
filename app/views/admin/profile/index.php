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
                <div class="col-md-4 mt-4">
                  <img src="<?php echo $data['user']->photo_id ? URLROOT . '/images/users/' . $data['photo'] : AVATAR ?>" alt="..." class="img-fluid rounded p-2">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                  <p class="card-text my-2 ">Họ và tên: <strong><?php echo $data['user']->last_name . ' ' . $data['user']->first_name ?></strong></p>
                  <p class="card-text my-2">Email: <strong><?php echo $data['user']->email; ?></strong></p>
                  <p class="card-text my-2">Ngày tham gia: <strong><?php echo $data['user']->created_at; ?></strong></p>
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
