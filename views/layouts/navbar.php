<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}
require_once "Models/NotificationModel.php";
$notificationModel = new NotificationModel();
$unread_count = $notificationModel->countUnread($_SESSION['user_id']);
?>

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
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" id="sidebarToggle" aria-label="Toggle Sidebar">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Notifications Dropdown-->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#" role="button" id="notificationsDropdown" aria-label="Notifications">
                            <i class="bi bi-bell fs-5 text-muted"></i>
                            <?php if ($unread_count > 0): ?>
                                <span class="badge bg-danger position-absolute notification-badge custom-pulse" style="top: -5px; right: -5px; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                    <?= $unread_count > 9 ? '9+' : $unread_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-lg border-0 rounded-3 p-2" style="min-width: 400px;">
                            <div class="dropdown-header bg-primary text-white d-flex justify-content-between align-items-center p-3 rounded-top">
                                <h6 class="mb-0 fw-semibold">Notifications</h6>
                                <span class="badge bg-light text-primary rounded-pill"><?= $unread_count ?> unread</span>
                            </div>
                            <div class="dropdown-body" style="max-height: 400px; overflow-y: auto;" id="notificationDropdownContent">
                                <?php if ($unread_count > 0): ?>
                                    <?php foreach ($notificationModel->getNotifications($_SESSION['user_id'], 5, true) as $notification): ?>
                                        <?php $types = $notificationModel->getNotificationTypes(); ?>
                                        <a href="<?= htmlspecialchars($notification['link'] ?? '#') ?>" 
                                           class="dropdown-item d-flex align-items-center p-3 my-1 rounded-2 notification-item <?= !$notification['is_read'] ? 'unread' : '' ?>"
                                           data-notification-id="<?= htmlspecialchars($notification['notification_id']) ?>">
                                            <div class="notification-icon bg-<?= $types[$notification['type']]['color'] ?> text-white me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bi <?= $types[$notification['type']]['icon'] ?>"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fw-medium text-dark"><?= htmlspecialchars($notification['message']) ?></p>
                                                <small class="text-muted"><?= date('M d, h:i A', strtotime($notification['created_at'])) ?></small>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                    <div class="dropdown-footer bg-light p-2 rounded-bottom text-center">
                                        <a href="/notification" class="text-primary fw-semibold d-block py-2">View all notifications</a>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center p-4">
                                        <i class="bi bi-bell-slash fs-3 text-muted"></i>
                                        <p class="text-muted mt-2 mb-0">No new notifications</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <!--end::Notifications Dropdown-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center position-relative" data-bs-toggle="dropdown" aria-label="User Menu">
                            <?php
                            $userImage = isset($_SESSION['image']) && !empty($_SESSION['image']) 
                                ? '/uploads/' . htmlspecialchars($_SESSION['image'], ENT_QUOTES, 'UTF-8') 
                                : null;
                            $imagePath = $userImage ? $_SERVER['DOCUMENT_ROOT'] . $userImage : null;
                            $userFirstName = $_SESSION['first_name'] ?? 'Unknown';
                            $userLastName = $_SESSION['last_name'] ?? '';
                            $fullName = trim("$userFirstName $userLastName");
                            $initials = strtoupper(substr($userFirstName, 0, 1) . substr($userLastName, 0, 1));
                            ?>
                            <?php if ($userImage && file_exists($imagePath)): ?>
                                <img src="<?= htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8') ?>"
                                     class="user-image rounded-circle shadow-sm me-2"
                                     alt="User Image"
                                     width="30"
                                     height="30"
                                     style="border: 2px solid #007bff; transition: transform 0.3s ease;">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 12px; height: 12px; border: 2px solid #fff;"></span>
                            <?php else: ?>
                                <div class="user-initials rounded-circle shadow-sm me-2 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background-color: #007bff; font-size: 16px; font-weight: bold;">
                                    <?= htmlspecialchars($initials) ?>
                                </div>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0 rounded-3">
                            <li class="user-header text-center p-3 border-bottom" style="background: linear-gradient(135deg, #007bff, #0056b3); color: #fff;">
                                <?php if ($userImage && file_exists($imagePath)): ?>
                                    <img src="<?= htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8') ?>"
                                         class="rounded-circle shadow-sm mb-2"
                                         alt="User Image"
                                         width="80"
                                         height="80">
                                <?php else: ?>
                                    <div class="user-initials rounded-circle shadow-sm mb-2 d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; background-color: #007bff; font-size: 32px; font-weight: bold;">
                                        <?= htmlspecialchars($initials) ?>
                                    </div>
                                <?php endif; ?>
                                <p class="mb-0 fw-bold"><?= htmlspecialchars($fullName ?: 'Unknown') ?></p>
                                <small class="opacity-75"><?= htmlspecialchars($_SESSION['user_role'] ?? 'Role Unknown') ?></small>
                            </li>
                            <li class="p-2">
                                <a href="/users/profile" class="dropdown-item d-flex align-items-center text-dark">
                                    <i class="bi bi-person-circle me-2 text-primary"></i> Profile
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center text-dark">
                                    <i class="bi bi-gear me-2 text-primary"></i> Settings
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