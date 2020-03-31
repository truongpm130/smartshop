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

        <?php flash('message'); ?>

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Products - Categories</h1>
          <a href="<?php echo URLROOT; ?>/categoryProduct/add" class="btn btn-primary d-inline-block float-right"><i class="fa fa-plus"></i> Add Categories</a>

          <!-- Users Controller -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>slug</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data['categories'] as $category) : ?>
              <tr>
                <td><?php echo $category->id; ?></td>
                <td><?php echo $category->name; ?></td>
                <td><?php echo $category->slug; ?></td>
                <td>
                  <a href="<?php echo URLROOT; ?>/categoryProduct/edit/<?php echo $category->id; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Chỉnh sửa"><i class="far fa-edit"></i></a>
                  
                  <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteCategoryModal<?php echo $category->id ?>"><i class="fa fa-trash"></i></a>
                  <input type="hidden" name="id" id="user<?php echo $category->id; ?>" value="<?php echo $category->id; ?>">
                </td>
              </tr>

              <!-- Delete Category Modal -->
                <div class="modal fade" id="deleteCategoryModal<?php echo $category->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you really want to delete this category ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        All Post of this Category will be lost!
                      </div>
                      <div class="modal-footer">
                        <form action="<?php echo URLROOT; ?>/categoryProduct/delete/<?php echo $category->id; ?>" method="post">
                          <input type="hidden" name="user_id" class="user_delete_id" value="<?php echo $category->id; ?>">
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
