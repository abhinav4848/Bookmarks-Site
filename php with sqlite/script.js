function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const categories = document.querySelectorAll(".category");
    let hasMatch = false;
    let visibleRows = 0;

    categories.forEach(category => {
        const rows = category.querySelectorAll("tbody tr");
        let categoryHasMatch = false;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(input);
            row.style.display = isMatch ? "" : "none";
            if (isMatch) {
                categoryHasMatch = true;
                visibleRows++;
            }
        });

        category.style.display = categoryHasMatch ? "" : "none";
        if (categoryHasMatch) hasMatch = true;
    });

    document.getElementById("footer").style.display = hasMatch ? "block" : "none";
    document.getElementById("footerCount").textContent = visibleRows;
}

document.getElementById("searchInput").addEventListener("input", filterTable);
