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
              <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <i class="bi bi-bell-fill fs-5 text-dark"></i>
                <span class="badge bg-warning position-absolute notification-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-lg border-0 rounded-3 p-2" style="min-width: 350px;">
                <!-- Header -->
                <div class="dropdown-header d-flex align-items-center justify-content-between p-3 bg-primary text-white rounded-top">
                  <span class="fw-semibold fs-6">Notifications</span>
                  <span class="badge bg-light text-primary rounded-pill">15</span>
                </div>
                <!-- Notification Items -->
                <div class="dropdown-body" style="max-height: 300px; overflow-y: auto;">
                  <a href="#" class="dropdown-item d-flex align-items-center p-3 rounded-2 my-1">
                    <div class="bg-orange text-white d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 40px; height: 40px;">
                      <i class="bi bi-envelope fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                      <p class="mb-0 fw-medium text-dark">4 new messages</p>
                      <small class="text-muted">3 mins ago</small>
                    </div>
                  </a>
                  <a href="#" class="dropdown-item d-flex align-items-center p-3 rounded-2 my-1">
                    <div class="bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 40px; height: 40px;">
                      <i class="bi bi-check-circle fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                      <p class="mb-0 fw-medium text-dark">Stock updated</p>
                      <small class="text-muted">10 mins ago</small>
                    </div>
                  </a>
                </div>
                <!-- Footer -->
                <div class="dropdown-footer p-2 bg-light rounded-bottom">
                  <a href="#" class="d-block text-center text-primary fw-semibold py-2 rounded-2">
                    See All Notifications
                  </a>
                </div>
              </div>
            </li>
            <!--end::Notifications Dropdown-->
            <style>
              /* Enhance dropdown appearance */
              .dropdown-menu {
                border: none !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                background-color: #fff;
                border-radius: 12px !important;
                
              }

              .notification-badge {
                top: 30% !important;
                right: -60% !important;
                transform: translate(-50%, -50%) !important;
                font-size: 0.75rem;
                padding: 0.25em 0.5em;
                border-radius: 50% !important;
                border: 1px solid white;
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
              }

              /* Hover effect for dropdown items */
              .dropdown-item {
                transition: background-color 0.2s ease;
              }

              .dropdown-item:hover {
                background-color: #f8f9fa !important;
              }

              /* Footer link hover effect */
              .dropdown-footer a {
                text-decoration: none;
                transition: all 0.2s ease;
              }

              .dropdown-footer a:hover {
                background-color: #007bff !important;
                color: #fff !important;
              }

              /* Badge styling */
              .badge {
                font-size: 0.75rem;
                padding: 0.35em 0.65em;
              }
            </style>


            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img
                  src="<?= isset($_SESSION['user_image']) ? $_SESSION['user_image'] : '/views/images/user.png'; ?>"
                  class="user-image rounded-circle shadow-sm me-2"
                  alt="User Image"
                  width="35"
                  height="35" />
                <!-- admin -->
                <?php if (isset($_SESSION['user_role'])): ?>
                  <span class="d-none d-md-inline text-dark fw-semibold"><?= $_SESSION['user_role']; ?></span>
                <?php endif; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0 rounded-3">
                <li class="user-header text-center p-3 bg-light border-bottom">
                  <img
                    src="<?= isset($_SESSION['user_image']) ? $_SESSION['user_image'] : '/views/images/user.png'; ?>"
                    class="rounded-circle shadow-sm mb-2"
                    alt="User Image"
                    width="80"
                    height="80" />
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
            <p class="text-secondary text-uppercase fw-semibold px-3 small", >Navigations</p>
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