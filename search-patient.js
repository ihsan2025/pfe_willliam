
        //  document.addEventListener("DOMContentLoaded", function() {
            // Initialize DataTable using jQuery DataTables plugin
            // var table = $('#resultsTable').DataTable();
            // alert('test');

            // Handle search button click
            // document.getElementById("searchButton").addEventListener("click", function() {

            function test() {
                var table = $('#resultsTable').DataTable();
                alert('test');

                var searchTerm = document.getElementById("searchInput").value.trim();

                if (searchTerm !== '') {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "search-patient.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);

                            // Clear the table before inserting new data
                            table.clear().draw();

                            // Insert the fetched data into the table
                            data.forEach(function(item) {
                                table.row.add([
                                    item.id,
                                    item.name,
                                    item.specialization
                                ]).draw(false);
                            });
                        } else if (xhr.readyState === 4) {
                            alert("Error: " + xhr.statusText);
                        }
                    };

                    xhr.send("search=" + encodeURIComponent(searchTerm));
                } else {
                    alert("Please enter a search term.");
                }
            }
        //     });
        // });
