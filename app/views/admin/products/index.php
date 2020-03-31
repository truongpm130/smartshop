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

        <?php flash('message'); ?>

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Products</h1>
          <a href="<?php echo URLROOT; ?>/products/add" class="btn btn-primary d-inline-block float-right"><i class="fa fa-plus"></i> Add Product</a>

          <!-- Users Controller -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Thể loại</th>
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Miêu tả</th>
                <th>Trạng thái</th>
                <th>Lượt xem</th>
                <th>Action</th>                
              </tr>
            </thead>
            <tbody>
              <?php foreach($data['products'] as $product) : ?>
              <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $data['categories'][$product->id]; ?></td>
                <td><?php echo strlimit($product->name, 50) ?></td>
                <td><img src="<?php echo URLROOT . '/images/products/' . $data['photos'][$product->id] ?>" alt="" class="img-fluid"></td>
                <td><?php echo $product->price; ?></td>
                <td><?php echo strlimit($product->description, 100) ?></td>
                
                <td><?php echo $product->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                <td><?php echo $product->counter; ?></td>
                <td>
                  <a href="<?php echo URLROOT; ?>/products/edit/<?php echo $product->id; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Chỉnh sửa"><i class="far fa-edit"></i></a>
                  <?php if($product->status) : ?>
                    <a href="<?php echo URLROOT; ?>/products/inactive/<?php echo $product->id; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Inactive"><i class="fas fa-times"></i></a>
                  <?php else : ?>
                    <a href="<?php echo URLROOT; ?>/products/active/<?php echo $product->id; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Active"><i class="fas fa-check"></i></a>
                  <?php endif; ?>
                  <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal<?php echo $product->id ?>"><i class="fa fa-trash"></i></a>
                  <input type="hidden" name="id" id="user<?php echo $product->id; ?>" value="<?php echo $product->id; ?>">
                </td>
              </tr>

              <!-- Delete User Modal -->
                <div class="modal fade" id="deleteProductModal<?php echo $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you really want to delete this product ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        This products will be deleted !
                      </div>
                      <div class="modal-footer">
                        <form action="<?php echo URLROOT; ?>/products/delete/<?php echo $product->id; ?>" method="product">
                          <input type="hidden" name="user_id" class="user_delete_id" value="<?php echo $product->id; ?>">
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
