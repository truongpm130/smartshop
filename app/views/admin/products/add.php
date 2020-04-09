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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Products - Add</h1>
                <a href="<?php echo URLROOT; ?>/admin/products" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Add Products -->
                <form action="<?php echo URLROOT; ?>/products/add" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name: </label>
                        <input type="text" name="name" id="product_name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" required>
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
                        <label for="price">Price: </label>
                        <input type="number" name="price" min="1" id="" class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="category"> Category: </label>
                        <select name="category" id="" class="form-control" required>
                            <option value="">Choose Category</option>
                            <?php foreach ($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id ?>"
                                    <?php
                                        if (isset($data['category'])) {
                                            if ($data['category'] == $category->id) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>><?php echo $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="my-3">
                        <label for="file">Photo</label>
                        <input type="file" name="file" id="">
                        <?php if(!empty($data['file_err'])) :?>
                        <?php foreach ($data['file_err'] as $item) :?>
                            <p class="text-danger text-small"><?php echo $item ?></p>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Description: </label>
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

                    <input type="submit" value="Add Product" class="btn btn-primary btn-block">
                </form>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>