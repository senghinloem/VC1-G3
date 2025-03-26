document.getElementById('form-control').addEventListener('keyup', filterProductsByName);

                function filterProductsByName() {
                    const input = document.getElementById("form-control");
                    const filter = input.value.toUpperCase();

                    const table = document.getElementById("productTable");
                    const rows = table.getElementsByTagName("tr");
                    let visibleRowCount = 0;

                    for (let i = 1; i < rows.length; i++) {
                        const nameCell = rows[i].getElementsByTagName("td")[2];
                        const priceCell = rows[i].getElementsByTagName("td")[4];

                        if (nameCell && priceCell) {
                            const nameValue = nameCell.textContent || nameCell.innerText;
                            const priceValue = parseFloat(priceCell.textContent || priceCell.innerText);

                            const matchesName = nameValue.toUpperCase().includes(filter);
                            const matchesPrice = priceValue.toString().includes(filter);

                            if (matchesName || matchesPrice) {
                                rows[i].style.display = "";
                                visibleRowCount++;
                            } else {
                                rows[i].style.display = "none";
                            }
                        }
                    }

                    const noProductsMessage = document.getElementById("no-products-message");
                    if (visibleRowCount === 0) {
                        noProductsMessage.style.display = "";
                    } else {
                        noProductsMessage.style.display = "none";
                    }
                }

                document.getElementById('form-select').addEventListener('change', function() {
                    const selectedUnit = this.value.toUpperCase();
                    const table = document.getElementById("productTable");
                    const rows = table.getElementsByTagName("tr");

                    for (let i = 1; i < rows.length; i++) { // Skip header row
                        const unitCell = rows[i].getElementsByTagName("td")[5]; // Unit column
                        if (unitCell) {
                            const unitValue = unitCell.textContent || unitCell.innerText;
                            if (selectedUnit === "" || unitValue.toUpperCase() === selectedUnit) {
                                rows[i].style.display = ""; // Show row
                            } else {
                                rows[i].style.display = "none"; // Hide row
                            }
                        }
                    }
                });