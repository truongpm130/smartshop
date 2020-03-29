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

        <div id="test">

        </div>

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Posts</h1>
          <a href="<?php echo URLROOT; ?>/users/add" class="btn btn-primary d-inline-block float-right"><i class="fa fa-plus"></i> Add Post</a>

          <!-- Users Controller -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
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
                <td><?php echo $user->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                <td>
                  <?php 
                    if ($data['role_user']) {
                      for ($i = 0; $i < count($data['role_user']); $i++) {
                        if ($user->id === $data['role_user'][$i]->userId) {
                          echo $data['role_user'][$i]->roleName;
                        } else {
                          echo '';
                        }
                      }
                    } else {
                      echo '';
                    }
                  ?>
                </td>
                <td><?php echo $user->created_at; ?></td>
                <td>
                  <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Chỉnh sửa"><i class="far fa-edit"></i></a>
                  <?php if($user->status) : ?>
                    <a href="<?php echo URLROOT; ?>/users/inactive/<?php echo $user->id; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Inactive"><i class="fas fa-times"></i></a>
                  <?php else : ?>
                    <a href="<?php echo URLROOT; ?>/users/active/<?php echo $user->id; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Active"><i class="fas fa-check"></i></a>
                  <?php endif; ?>
                  <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal<?php echo $user->id ?>"><i class="fa fa-trash"></i></a>
                  <input type="hidden" name="id" id="user<?php echo $user->id; ?>" value="<?php echo $user->id; ?>">
                </td>
              </tr>

              <!-- Delete User Modal -->
                <div class="modal fade" id="deleteUserModal<?php echo $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id; ?>" method="post">
                          <input type="hidden" name="user_id" class="user_delete_id" value="<?php echo $user->id; ?>">
                          <button type="button" class="btn btn-secondary"  data-dismiss="modal">Hủy Bỏ</button>
                          <button type="submit" class="btn btn-danger btn_delete">Xóa</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <!-- /Delete User Modal  --> 

              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>
