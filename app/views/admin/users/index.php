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
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Users</h1>
          <a href="<?php echo URLROOT; ?>/users/add" class="btn btn-primary d-inline-block float-right"><i class="fa fa-plus"></i> Add User</a>

          <!-- Users Controller -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created_at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data['users'] as $user) : ?>
              <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->last_name . ' ' . $user->first_name; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->status ? 'Active' : 'Inactive'; ?></td>
                <td><?php echo $user->created_at; ?></td>
                <td>
                  <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Chỉnh sửa"><i class="far fa-edit"></i></a>
                  <a href="#" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Active"><i class="fas fa-check"></i></a>
                  <a href="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Xóa"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Delete User Modal -->
      <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are you really want to delete this user ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            All user's information will be lost !
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy Bỏ</button>
            <a href="<?php echo URLROOT; ?>/users/delete/1" class="btn btn-danger">Xóa</a>
          </div>
        </div>
      </div>
    </div>

      <!-- Footer -->
      <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>
