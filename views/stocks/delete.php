<div class="modal fade" id="stock<?= $stock['stock_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this stock?
            </div>
            <div class="modal-footer">
                <form action="/stock/destroy/<?= $stock['stock_id'] ?>" method="POST" id="deleteForm<?= $stock['stock_id'] ?>">
                    <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $stock['stock_id'] ?>)">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript to show confirmation prompt and submit the form if confirmed
    function confirmDelete(stockId) {
        // Add a console log to see if this is being triggered
        console.log("Delete confirmation triggered for stockId: " + stockId);

        // Show the confirmation dialog
        const confirmation = confirm("Are you sure you want to delete this stock?");
        if (confirmation) {
            // If confirmed, submit the form
            console.log("Confirmed. Submitting the form for stockId: " + stockId);
            document.getElementById('deleteForm' + stockId).submit(); 
        } else {
            // If not confirmed, log cancellation
            console.log("Deletion canceled for stockId: " + stockId);
        }
    }
</script>
