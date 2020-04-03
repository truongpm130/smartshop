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
        <div class="no-gutters">
          <h1 class="h3 mb-4 text-gray-800 d-inline-block">Products</h1>
          <a href="<?php echo URLROOT; ?>/products/add" class="btn btn-primary d-inline-block float-right"><i class="fa fa-plus"></i> Add Product</a>
        </div>

        <!-- Filter -->
        <div class="div">
          <div class="dropdown d-inline-block mb-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Category
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a href="<?php echo URLROOT; ?>/products/index" class="dropdown-item">All</a>
              <?php foreach ($data['category_all'] as $category) : ?>
                <a class="dropdown-item" href="<?php echo URLROOT ?>/products/getByCategory/<?php echo $category->id ?>"><?php echo $category->name ?></a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Search Products in current page by JS-->
          <div class="d-d-inline-block float-right">
            <input type="text" name="" id="searchProduct" placeholder="Tìm sản phẩm trong trang" class="form-control mx-2">
          </div>
        </div>

        <!-- Search entry products -->
        <div class="form-group d-inline-block">
          <form action="<?php echo URLROOT; ?>/products/search" method="post" class="form-inline">
            <div class="form-group">
              <label for="search"></label>
              <input type="text" name="search" id="" class="form-control" placeholder="Tìm sản phẩm">
            </div>
            <button type="submit" class="btn btn-outline-dark"><i class="fas fa-search"></i></button>
          </form>
        </div>

        <!-- Sort -->
        <div class="dropdown d-inline-block float-right">
          <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sắp xếp
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?php echo URLROOT; ?>/products/priceAsc">Giá tăng dần</a>
            <a class="dropdown-item" href="<?php echo URLROOT; ?>/products/priceDesc">Giá giảm dần</a>
          </div>
        </div>


        <!-- Products Index -->
        <table class="table table-striped" id="productTable">
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
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['products'] as $product) : ?>
              <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $data['categories'][$product->id]; ?></td>
                <td><?php echo strlimit($product->name, 50) ?></td>
                <td><img src="<?php echo URLROOT . '/images/products/' . $data['photos'][$product->id] ?>" alt="" class="rounded" height="80"></td>
                <td class="text-danger font-weight-bolder">
                  <span><?php echo number_format($product->price); ?><sup>đ</sup></span>
                </td>
                <td><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#showProductModal<?php echo $product->id ?>"><i class="fas fa-search"></i></a></td>

                <td><?php echo $product->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                <td><?php echo $product->counter ? $product->counter : '0'; ?></td>
                <td>
                  <table>
                    <tr>
                      <td>
                        <a href="<?php echo URLROOT; ?>/products/edit/<?php echo $product->id; ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Chỉnh sửa"><i class="far fa-edit"></i></a>
                      </td>
                      <td>
                        <?php if ($product->status) : ?>
                          <a href="<?php echo URLROOT; ?>/products/inactive/<?php echo $product->id; ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Inactive"><i class="fas fa-times"></i></a>
                        <?php else : ?>
                          <a href="<?php echo URLROOT; ?>/products/active/<?php echo $product->id; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Active"><i class="fas fa-check"></i></a>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal<?php echo $product->id ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  </table>

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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy Bỏ</button>
                        <button type="submit" class="btn btn-danger btn_delete">Xóa</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Delete User Modal  -->

              <!-- Show Products Description Modal -->
              <div class="modal fade" id="showProductModal<?php echo $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"><?php echo $product->name ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php echo $product->description; ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Show Products Description  -->

            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="...">
          <ul class="pagination">
            <li class="page-item <?php echo $data['cur_page'] <= 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="<?php echo '?cur_page=' . ($data['cur_page'] - 1) ?>" tabindex="-1">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $data['num_pages']; $i++) : ?>
              <li class="page-item <?php echo $data['cur_page'] == $i ? 'active' : '' ?>">
                <a class="page-link" href="<?php echo '?cur_page=' . $i ?>"><?php echo $i ?></a>
              </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $data['cur_page'] >= $data['num_pages'] ? 'disabled' : '' ?>">
              <a class="page-link" href="<?php echo '?cur_page=' . ($data['cur_page'] + 1) ?>">Next</a>
            </li>
          </ul>
        </nav>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <script>
      document.getElementById('searchProduct').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;

        input = document.getElementById('searchProduct');
        filter = input.value.toUpperCase();
        table = document.getElementById('productTable');
        tr = table.getElementsByTagName('tr');

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName('td')[2];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }


      });
    </script>

    <!-- Footer -->
    <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>