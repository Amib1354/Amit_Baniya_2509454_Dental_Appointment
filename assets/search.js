// Admin Live Search Function
function adminSearch(str) {
    const tbody = document.getElementById("dashboardBody");
    if (!tbody) return;

    let query = str.trim();
    fetch("ajax_admin_search.php?query=" + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "" && query !== "") {
                tbody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No matching records found.</td></tr>";
            } else {
                tbody.innerHTML = data;
            }
        });
}

// Patient Live Search Function
function liveSearch(str) {
    const list = document.getElementById("results-list");
    if (!list) return;

    if (str.length == 0) {
        list.innerHTML = "";
        return;
    }
    fetch("ajax_search.php?query=" + encodeURIComponent(str))
        .then(response => response.text())
        .then(data => {
            list.innerHTML = data;
        });
}