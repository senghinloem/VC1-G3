<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Use an absolute path from the project root
require_once __DIR__ . "/../../Models/NotificationModel.php";

$notificationModel = new NotificationModel();
$notifications = isset($_SESSION['user_id']) ? $notificationModel->getUserNotifications($_SESSION['user_id']) : [];
$notificationCount = isset($_SESSION['user_id']) ? $notificationModel->getNotificationCount($_SESSION['user_id']) : 0;
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
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" id="sidebarToggle">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Notifications Dropdown-->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="bi bi-bell-fill fs-5 text-dark"></i>
                            <?php if ($notificationCount > 0): ?>
                            <span
                                class="badge bg-warning position-absolute notification-badge"><?php echo $notificationCount; ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-lg border-0 rounded-3 p-2"
                            style="min-width: 350px;">
                            <!-- Header -->
                            <div
                                class="dropdown-header d-flex align-items-center justify-content-between p-3 bg-primary text-white rounded-top">
                                <span class="fw-semibold fs-6">Notifications</span>
                                <span
                                    class="badge bg-light text-primary rounded-pill"><?php echo $notificationCount; ?></span>
                            </div>
                            <!-- Notification Items -->
                            <div class="dropdown-body" style="max-height: 300px; overflow-y: auto;">
                                <?php if (empty($notifications)): ?>
                                <div class="dropdown-item text-center p-3">
                                    <p class="mb-0 text-muted">No new notifications</p>
                                </div>
                                <?php else: ?>
                                <?php foreach ($notifications as $notification): ?>
                                <a href="#" class="dropdown-item d-flex align-items-center p-3 rounded-2 my-1">
                                    <div class="bg-<?php echo $notification['type'] === 'success' ? 'success' : ($notification['type'] === 'error' ? 'danger' : 'info'); ?> text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                        style="width: 40px; height: 40px;">
                                        <i
                                            class="bi bi-<?php echo $notification['type'] === 'success' ? 'check-circle' : ($notification['type'] === 'error' ? 'x-circle' : 'info-circle'); ?> fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">

                                        <p class="mb-0 fw-medium text-dark">
                                            <?php echo htmlspecialchars($notification['message']); ?></p>
                                        <small
                                            class="text-muted"><?php echo date('H:i d M', strtotime($notification['created_at'])); ?></small>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <!-- Footer -->
                            <div class="dropdown-footer p-2 bg-light rounded-bottom">
                                <a href="/notifications"
                                    class="d-block text-center text-primary fw-semibold py-2 rounded-2">
                                    See All Notifications
                                </a>
                            </div>
                        </div>
                    </li>
                    <!--end::Notifications Dropdown-->
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <?php
                                $userImage = isset($_SESSION['image']) && !empty($_SESSION['image']) 
                                    ? '/uploads/' . htmlspecialchars($_SESSION['image'], ENT_QUOTES, 'UTF-8') 
                                    : '/views/assets/img/user2-160x160.jpg';
                                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $userImage;
                                if (!file_exists($imagePath)) {
                                    $userImage = '/views/assets/img/user2-160x160.jpg';
                                }
                                $userFirstName = $_SESSION['first_name'] ?? 'Unknown';
                                $userLastName = $_SESSION['last_name'] ?? '';
                                $fullName = trim("$userFirstName $userLastName");
                                ?>
                            <img src="<?= htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8') ?>"
                                class="user-image rounded-circle shadow-sm me-2" alt="User Image" width="40"
                                height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0 rounded-3">
                            <li class="user-header text-center p-3 bg-light border-bottom">
                                <img src="<?= htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8') ?>"
                                    class="rounded-circle shadow-sm mb-2" alt="User Image" width="80" height="80">
                                <p class="mb-0 fw-bold">
                                    <?= htmlspecialchars($fullName ?: 'Unknown') ?>
                                </p>
                                <small class="opacity-75">
                                    <?= htmlspecialchars($_SESSION['user_role'] ?? 'Role Unknown') ?>
                                </small>
                            </li>
                            <li class="p-2">
                                <a href="/users/profile" class="dropdown-item d-flex align-items-center">
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
        <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark" id="sidebar">
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
                            <a href="/category" class="nav-link text-white">
                                <i class="bi bi-tags-fill"></i>
                                <span class="ms-2">Category</span>
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
                        <li class="nav-item">
                            <a href="/notifications" class="nav-link text-white">
                                <i class="bi bi-bell-fill"></i>
                                <span class="ms-2">Notifications</span>
                            </a>
                        </li>
                    </ul>

                    <div class="mt-4 border-top pt-3">
                        <ul class="nav sidebar-menu flex-column">
                            <!-- <li class="nav-item">
                                    <a href="/setting" class="nav-link text-white">
                                        <i class="bi bi-gear-fill"></i>
                                        <span class="ms-2">Settings</span>
                                    </a>
                                </li> -->
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
        <!-- Sidebar Toggle and Active Link Script -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');

            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('hidden');
                mainContent.classList.toggle('full-width');
            });

            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-menu .nav-link');
            sidebarLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (currentPath === linkPath) {
                    link.classList.add('active');
                }
            });
        });
        </script>
        <?php endif; ?>