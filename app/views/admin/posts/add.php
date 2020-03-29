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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Posts - Add</h1>
                <a href="<?php echo URLROOT; ?>/admin/posts" class="btn btn-secondary d-inline-block float-right"><i class="fa fa-arrow-left"></i> Back</a>

                <!-- Add Posts -->
                <form action="<?php echo URLROOT; ?>/posts/add" method="post">
                    <div class="form-group">
                        <label for="title">Tiêu đề: </label>
                        <input type="text" name="title" id="post_title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug: </label>
                        <input type="text" name="slug" id="post_slug" class="form-control" value="<?php echo $data['slug']; ?>">
                    </div>

                    <!-- Slug title -->
                    <script>
                        document.getElementById('post_title').addEventListener('keyup', function() {
                            ChangeToSlug('post_title', 'post_slug');
                        });

                    </script>

                    <div class="form-group">
                        <label for="category"> Thể Loại: </label>
                        <select name="category" id="" class="form-control">
                            <option value=""></option>
                            <?php foreach ($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="my-3">
                        <input type="file" name="file" id="">
                    </div>

                    <div class="form-group">
                        <label for="content">Nội Dung: </label>
                        <textarea name="content" id="editor" rows="10" class="form-control <?php echo (!empty($data['content_err']) ? 'is-invalid' : '') ?>" value="<?php echo $data['content']; ?>"></textarea>
                        <span class="invalid-feedback"><?php echo $data['content_err']; ?></span>
                        
                        <!-- CKeditor -->
                        <script>
                             ClassicEditor
                            .create( document.querySelector( '#editor' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                        </script>
                    </div>

                    <input type="submit" value="Thêm bài viết" class="btn btn-primary btn-block">
                </form>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php require_once APPROOT . '/views/includes/admin/footer.php' ?>