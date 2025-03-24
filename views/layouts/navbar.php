<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php if (isset($_SESSION['user_id'])): ?>
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-light">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list fs-4"></i>
              </a>
            </li>
          </ul>
          <!--end::Start Navbar Links-->
          <!-- Search Bar (Centered) -->
          
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Notifications Dropdown-->
            <li class="nav-item dropdown">
              <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill fs-5"></i>
                <span class="badge bg-warning position-absolute top-0 start-100 translate-middle">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-envelope me-2"></i> 4 new messages
                  <span class="float-end text-secondary fs-7">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer text-center text-primary fw-bold">See All Notifications</a>
              </div>
            </li>
            <!--end::Notifications Dropdown-->


            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img
                  src="<?= isset($_SESSION['user_image']) ? $_SESSION['user_image'] : '/views/assets/images/pn-logo.png'; ?>"
                  class="user-image rounded-circle shadow-sm me-2"
                  alt="User Image"
                  width="35"
                  height="35"
                />
                <?php if (isset($_SESSION['user_role'])): ?>
                  <span class="d-none d-md-inline text-dark fw-semibold"><?= $_SESSION['user_role']; ?></span>
                <?php endif; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0 rounded-3">
                <li class="user-header text-center p-3 bg-light border-bottom">
                  <img
                    src="<?= isset($_SESSION['user_image']) ? $_SESSION['user_image'] : '/views/assets/img/user2-160x160.jpg'; ?>"
                    class="rounded-circle shadow-sm mb-2"
                    alt="User Image"
                    width="80"
                    height="80"
                  />
                  <p class="mb-0 fw-bold">
                    <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>
                  </p>
                  <small class="opacity-75"><?= isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Role Unknown'; ?></small>
                  <br>
                </li>
                <li class="p-2">
                  <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i> Profile
                  </a>
                  <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-gear me-2"></i> Settings
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="/users/logout" class="dropdown-item d-flex align-items-center text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Log out
                  </a>
                </li>
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
      </nav>
      <!--end::Header-->

      <!-- Sidebar -->
      <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
        <div class="sidebar-brand text-center py-3">
          <a href="#" class="brand-link text-white fw-bold fs-5">PNN SHOP</a>
        </div>


        <div class="sidebar-wrapper">
          <nav class="mt-3">
            <p class="text-secondary text-uppercase fw-semibold px-3 small">Navigations</p>
            <ul class="nav sidebar-menu flex-column">
              <li class="nav-item">
                <a href="/dashboard" class="nav-link text-white">
                  <i class="bi bi-speedometer"></i>
                  <span class="ms-2">Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/products" class="nav-link text-white">
                  <i class="bi bi-palette"></i>
                  <span class="ms-2">Product Management</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/stock" class="nav-link text-white">
                  <i class="bi bi-box-seam-fill"></i>
                  <span class="ms-2">Stock Management</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/product_list" class="nav-link text-white">
                  <i class="bi bi-clipboard-fill"></i>
                  <span class="ms-2">Product List</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/supplier" class="nav-link text-white">
                  <i class="bi bi-tree-fill"></i>
                  <span class="ms-2">Suppliers Management</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/report" class="nav-link text-white">
                  <i class="bi bi-pencil-square"></i>
                  <span class="ms-2">Reports</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/users" class="nav-link text-white">
                  <i class="bi bi-person-gear"></i>
                  <span class="ms-2">User Management</span>
                </a>
              </li>
            </ul>

            <div class="mt-4 border-top pt-3">
              <ul class="nav sidebar-menu flex-column">
                <li class="nav-item">
                  <a href="/setting" class="nav-link text-white">
                    <i class="bi bi-gear-fill"></i>
                    <span class="ms-2">Settings</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/help" class="nav-link text-white">
                    <i class="bi bi-question-circle-fill"></i>
                    <span class="ms-2">Help</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/users/logout" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="ms-2">Logout</span>
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </aside>
<?php endif; ?>
