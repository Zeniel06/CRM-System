function toggleStatus(button) {
    let row = button.closest("tr"); //get the closest parent tr

    if (row.classList.contains("pending")) {
        row.classList.remove("pending");
        row.classList.add("complete");
        button.classList.remove("status-pending");
        button.classList.add("status-complete");
        button.textContent = "Complete";
    } else {
        row.classList.remove("complete");
        row.classList.add("pending");
        button.classList.remove("status-complete");
        button.classList.add("status-pending");
        button.textContent = "Pending";
    }
}
