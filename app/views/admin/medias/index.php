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
                <h1 class="h3 mb-4 text-gray-800 d-inline-block">Photos</h1>
                <form action="<?php echo URLROOT; ?>/photos/uploadPhoto" method="post" class="form-inline mb-3" enctype="multipart/form-data">
                    <input type="file" name="file" id="">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Upload photo</button>
                </form>

                <!-- Collapse Photos -->
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Users - Avatar
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row row-cols-1 row-cols-md-3" class="photos-custom">
                                    <?php foreach ($data['users'] as $photo) : ?>
                                        <div class="col-md-2 mb-3">
                                            <div class="card">
                                                <img src="<?php echo URLROOT ?>/images/users/<?php echo $photo->photoPath ?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo strlimit($photo->photoPath, 15) ?></h5>
                                                    <p class="card-text text-muted"><?php echo timeago($photo->photoCreatedAt) ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="" class="btn btn-secondary"><i class="far fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger float-right"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Products - Photos
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row row-cols-1 row-cols-md-3" class="photos-custom">
                                    <?php foreach ($data['photos'] as $photo) : ?>
                                        <div class="col-md-2 mb-3">
                                            <div class="card">
                                                <img src="<?php echo URLROOT ?>/images/products/<?php echo $photo->photoPath ?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo strlimit($photo->photoPath, 15) ?></h5>
                                                    <p class="card-text text-muted"><?php echo timeago($photo->photoCreatedAt) ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="" class="btn btn-secondary"><i class="far fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger float-right"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Homepage Photos
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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