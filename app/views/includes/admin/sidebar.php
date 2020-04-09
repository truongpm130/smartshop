<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URLROOT; ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="">
            <p class="sidebar-brand-text mx-3">SmartShop</p>
            <p class="text-small"><?php echo isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'No role' ?></p>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <?php if ($_SESSION['user_role']) :?>
      <?php if ($_SESSION['user_role'] == 'admin') :?>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Members -->
      <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/index">
              <i class="fas fa-users"></i>
              <span>Members</span></a>
      </li>
      <?php endif; ?>
      <?php endif; ?>

      <!-- Nav Item - Profile -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>">
          <i class="fas fa-user"></i>
          <span>Profile</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoSide" aria-expanded="true" aria-controls="collapseTwoSide">
          <i class="far fa-file"></i>
          <span>Pages</span>
        </a>
        <div id="collapseTwoSide" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo URLROOT ?>/posts/index">Posts</a>
            <a class="collapse-item" href="<?php echo URLROOT ?>/categoryPost/index">Category</a>
            <a class="collapse-item" href="#">Tag</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThreeSide" aria-expanded="true" aria-controls="collapseThreeSide">
          <i class="far fa-lightbulb"></i>
          <span>Products</span>
        </a>
        <div id="collapseThreeSide" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo URLROOT ?>/products/index">Products</a>
            <a class="collapse-item" href="<?php echo URLROOT ?>/productCategory/index">Category</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Medias -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/photos/index">
          <i class="fas fa-photo-video"></i>
          <span>Medias</span></a>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>