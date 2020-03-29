<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URLROOT; ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SmartShop</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Profile -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/admin/profile/<?php echo $_SESSION['user_id']; ?>">
          <i class="fas fa-user"></i>
          <span>Profile</span></a>
      </li>

      <!-- Nav Item - Members -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/admin/members">
          <i class="fas fa-users"></i>
          <span>Members</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="far fa-file"></i>
          <span>Pages</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo URLROOT ?>/admin/posts">Posts</a>
            <a class="collapse-item" href="<?php echo URLROOT ?>/admin/categoriesPosts">Category</a>
            <a class="collapse-item" href="cards.html">Tag</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>