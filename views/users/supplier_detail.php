<div class="container my-5">
  <!-- Large Card to display the supplier details -->
  <div class="card" style="max-width: 150vh; margin: 0 auto;">
    <h5 class="card-header text-center bg-primary text-white">Supplier Detail</h5>
    <div class="card-body">
      
      <!-- Display Supplier Id -->
      <div class="mb-3">
        <p class="card-text"><strong>Supplier ID:</strong> <?= htmlspecialchars($supplier['supplier_id']) ?></p>
      </div>

      <!-- Display Supplier Name -->
      <div class="mb-3">
        <p class="card-text"><strong>Supplier Name:</strong> <?= htmlspecialchars($supplier['supplier_name']) ?></p>
      </div>

      <!-- Display Phone -->
      <div class="mb-3">
        <p class="card-text"><strong>Phone:</strong> <?= htmlspecialchars($supplier['phone']) ?></p>
      </div>

      <!-- Display Email -->
      <div class="mb-3">
        <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($supplier['email']) ?></p>
      </div>

      <!-- Display Address -->
      <div class="mb-3">
        <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($supplier['address']) ?></p>
      </div>

      <!-- Display Create At (if exists) -->
      <?php if (isset($supplier['created_at'])): ?>
        <div class="mb-3">
          <p class="card-text"><strong>Created At:</strong> <?= htmlspecialchars($supplier['created_at']) ?></p>
        </div>
      <?php else: ?>
        <div class="mb-3">
          <p class="card-text text-muted">Creation date not available</p>
        </div>
      <?php endif; ?>

     <!-- Back Button -->
      <div class="text-end">
          <a href="/supplier" class="btn btn-primary">Back to Suppliers</a>
      </div>
    </div>
  </div>
</div>
