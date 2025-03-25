document.querySelector(".logout-container").addEventListener("click", () => {
    window.location.href = "signin.php";

    setTimeout(() => {
        history.pushState(null, null, "signin.php");
    }, 0);
});

window.addEventListener("popstate", function () {
    history.pushState(null, null, "signin.php");
});