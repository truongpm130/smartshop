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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Products - Edit</h1>
                <a href="<?php echo URLROOT; ?>/admin/products" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Edit Products -->
                <form action="<?php echo URLROOT; ?>/products/edit/<?php echo $data['id'] ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm: </label>
                        <input type="text" name="name" id="product_name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug: </label>
                        <input type="text" name="slug" id="product_slug" class="form-control" value="<?php echo $data['slug']; ?>">
                    </div>

                    <!-- Slug title -->
                    <script>
                        document.getElementById('product_name').addEventListener('keyup', function() {
                            ChangeToSlug('product_name', 'product_slug');
                        });

                    </script>

                    <div class="form-group">
                        <label for="price">Giá: </label>
                        <input type="number" name="price" min="1" id="" class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']; ?>">
                        <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="category"> Thể Loại: </label>
                        <select name="category" id="" class="form-control">
                            <option value="<?php echo $data['category']->categoryId ?>"><?php echo $data['category']->categoryName ?></option>
                            <?php foreach ($data['categories'] as $category) : ?>
                                <?php if($category->id == $data['category']->categoryId) {
                                    continue;
                                } ?>
                                <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="my-3">
                        <label for="file">Photo</label>
                        <input type="file" name="file" id="">
                    </div>

                    <div class="form-group">
                        <label for="description">Miêu tả: </label>
                        <textarea name="description" id="editor_product" rows="10" class="form-control <?php echo (!empty($data['description_err']) ? 'is-invalid' : '') ?>"><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                        
                        <!-- CKeditor -->
                        <script>
                             ClassicEditor
                            .create( document.querySelector( '#editor_product' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                        </script>
                    </div>

                    <input type="submit" value="Cập nhật sản phẩm" class="btn btn-primary btn-block">
                </form>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>