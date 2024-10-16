import "./bootstrap";

import Alpine from "alpinejs";
import axios from "axios";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const contentContainer = document.getElementById("content-container");
    const navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const url = link.getAttribute("href");
            const target = link.getAttribute("data-target");

            // Update URL tanpa refresh
            history.pushState(null, "", url);

            // Ambil konten halaman menggunakan AJAX
            axios
                .get(url)
                .then((response) => {
                    // Update konten halaman
                    contentContainer.innerHTML = response.data;

                    // Update status aktif pada navigasi
                    navLinks.forEach((navLink) =>
                        navLink.classList.remove("active")
                    );
                    link.classList.add("active");
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });
});

// // Import jQuery and DataTables
// import $ from "jquery";
// import "datatables.net-bs4";

// // Make jQuery globally available (if needed in Blade templates)
// window.$ = window.jQuery = $;
