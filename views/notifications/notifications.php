<?php
require_once __DIR__ . '/../../views/layouts/navbar.php';
if (!isset($data['notifications']) || !is_array($data['notifications'])) {
    $data['notifications'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">All Notifications</h4>
            </div>
            <div class="card-body">
                <?php if (empty($data['notifications'])): ?>
                    <div class="alert alert-info text-center">
                        Don't have notifications found.
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($data['notifications'] as $notification): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="bg-<?php 
                                        echo isset($notification['type']) && $notification['type'] === 'success' ? 'success' : 
                                            (isset($notification['type']) && $notification['type'] === 'error' ? 'danger' : 
                                            (isset($notification['type']) && $notification['type'] === 'warning' ? 'warning' : 'info')); 
                                        ?> text-white d-flex align-items-center justify-content-center rounded-circle me-3" 
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-<?php 
                                            echo isset($notification['type']) && $notification['type'] === 'success' ? 'check-circle' : 
                                                (isset($notification['type']) && $notification['type'] === 'error' ? 'x-circle' : 
                                                (isset($notification['type']) && $notification['type'] === 'warning' ? 'exclamation-triangle' : 'info-circle')); 
                                            ?> fs-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">
                                            <?php echo htmlspecialchars($notification['message'] ?? 'No message'); ?>
                                        </p>
                                        <small class="text-muted">
                                            <?php echo isset($notification['created_at']) ? date('H:i d M Y', strtotime($notification['created_at'])) : 'Unknown time'; ?>
                                        </small>
                                    </div>
                                </div>
                                <div>
                                    <form action="/notifications/delete/<?php echo $notification['notification_id'] ?? ''; ?>" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>