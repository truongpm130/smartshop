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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Categories Products - Add</h1>
                <a href="<?php echo URLROOT; ?>/admin/categoriesProducts" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Add Category -->
                <div class="row">
                    <div class="col-md-6 offset-3">
                        <form action="<?php echo URLROOT; ?>/categoryProduct/add" method="post">
                            <div class="form-group">
                                <label for="name">Thể loại: </label>
                                <input type="text" name="name" id="category_name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug </label>
                                <input type="text" name="slug" id="category_slug" class="form-control">
                            </div>

                            <input type="submit" value="Tạo" class="btn btn-primary btn-block">
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>