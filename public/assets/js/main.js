const sidebar = document.querySelector(".sidebar");
const sidebarClose = document.querySelector("#sidebar-close");
const menu = document.querySelector(".menu-content");
const menuItems = document.querySelectorAll(".submenu-item");
const subMenuTitles = document.querySelectorAll(".submenu .menu-title");
sidebarClose.addEventListener("click", () => sidebar.classList.toggle("close"));
menuItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        menu.classList.add("submenu-active");
        item.classList.add("show-submenu");
        menuItems.forEach((item2, index2) => {
            if (index != index2) {
                item2.classList.remove("show-submenu");
            }
        });
    });
});
subMenuTitles.forEach((title) => {
    title.addEventListener("click", () => {
        menu.classList.remove("submenu-active");
    });
});

const dropdownBtn = document.querySelector(".dropbtn");
const dropdownContent = document.querySelector(".dropdown-content");
dropdownBtn.addEventListener("click", () => {
    dropdownContent.classList.toggle("show");
});
document.addEventListener("click", function (e) {
    if (
        !dropdownBtn.contains(e.target) &&
        !dropdownContent.contains(e.target)
    ) {
        dropdownContent.classList.remove("show");
    }
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$(document).ready(function () {
    $(document).on("click", function (event) {
        // Tutup semua dropdown jika klik di luar dropdown-container
        if (!$(event.target).closest(".dropdown-container").length) {
            $(".dropdown-p").addClass("hidden");
        }
    });
});

let onClickDD = (id) => {
    // Tutup semua dropdown yang terbuka terlebih dahulu
    $(".dropdown-p").addClass("hidden");

    // Toggle dropdown yang diklik
    let dropdown = $("#dropdownMenu-" + id);
    if (dropdown.hasClass("hidden")) {
        dropdown.removeClass("hidden");
    } else {
        dropdown.addClass("hidden");
    }
};

// function activate(id) {
//     const dropdown = document.getElementById(`dropdownMenu-${id}`);
//     dropdown.classList.toggle("hidden");
// }
