<div class="container mt-3">
  <input type="text" id="stockSearch" placeholder="Search by ID or Name" class="form-control mb-2">
  <button class="btn btn-primary" onclick="searchStock()">Search</button>

  <div id="searchResults" class="mt-3"></div>
</div>

<script>
  function searchStock() {
    const query = document.getElementById("stockSearch").value;
    fetch(`/stock/search?query=${query}`)
      .then(response => response.json())
      .then(data => {
        const resultContainer = document.getElementById("searchResults");
        if (data.message) {
          resultContainer.innerHTML = `<p class="text-danger">${data.message}</p>`;
        } else {
          resultContainer.innerHTML = data
            .map(stock => `<p>ID: ${stock.stock_id}, Name: ${stock.stock_name}</p>`)
            .join("");
        }
      });
  }
</script>
