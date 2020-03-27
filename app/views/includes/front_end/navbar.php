<div class="container">
      <nav class="navbar navbar-expand-xl navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>">SmartShop</a>
        <form class="form-inline mt-md-0 mr-auto">
          <input class="form-control mr-sm-2" type="text" placeholder="Bạn tìm mua gì..." aria-label="Search"
            id="searchForm">
          <button class="btn btn-dark my-sm-0" type="submit">
            <i class="fa fa-search fa-lg"></i>
          </button>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto text-uppercase">
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-mobile fa-lg"></i> - Điện Thoại</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-tablet fa-lg"></i> - Tablet</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-laptop fa-lg"></i> - Laptop</a>

            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-desktop fa-lg"></i> - Desktop</a>
            </li>
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-shopping-cart fa-lg"></i>
              </a>
            </li>
            <?php if (isLoggedIn()) : ?>
            <li class="nav-item">            
              <a href="<?php echo URLROOT ?>/admin/profile/<?php echo $_SESSION['user_id']; ?>" class="nav-link""><?php echo $_SESSION['user_name']; ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/users/logout" class="nav-link">Logout</a>
            </li>
            <?php else : ?>
            <li class="nav-item">            
              <a href="<?php echo URLROOT; ?>/users/login" class="nav-link"">Đăng nhập</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/users/register" class="nav-link">Đăng ký</a>
            </li>
            <?php endif;?>
          </ul>
        </div>
      </nav>
    </div>