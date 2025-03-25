// This is for the menu
const menuButton = document.querySelector('.menu-button');
const menu = document.querySelector('.menu');
const header = document.querySelector('.header');

let MenuOpen = false;

// Ensure the menu starts hidden
menu.style.display = "none";

menuButton.addEventListener('click', () => {
    if (!MenuOpen) {
        slideDown();
        header.style.backgroundColor = "black";
        MenuOpen = true;
    } else {
        slideUp();
        header.style.backgroundColor = "#333333";
        MenuOpen = false;
    }
});

function slideUp() {
    menu.style.transition = "all 0.5s ease-in-out";
    menu.style.opacity = "0"; // Fade out
    setTimeout(() => {
        menu.style.display = "none"; // Hide after animation
    }, 500);
}

function slideDown() {
    menu.style.display = "flex"; // Show first
    menu.style.opacity = "0"; // Start from invisible
    setTimeout(() => {
        menu.style.transition = "all 0.5s ease-in-out";
        menu.style.opacity = "1"; // Fade in
    }, 10); // Small delay for smooth transition
}

//This is for the Welcome Sign
document.addEventListener("DOMContentLoaded", function () {
    const welcomeText = document.querySelector(".welcome");

    function fadeInWelcome() {
        const rect = welcomeText.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.9) { // 90% into view
            welcomeText.classList.add("show");
            window.removeEventListener("scroll", fadeInWelcome); // Only triggers once
        }
    }

    window.addEventListener("scroll", fadeInWelcome);
    fadeInWelcome(); // Run once in case it's already visible
});
