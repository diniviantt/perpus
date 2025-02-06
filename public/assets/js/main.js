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
let onClickDD = (id) => {
    // Tutup semua dropdown yang terbuka
    let content = $(".dropdown-content");
    // content.each(function (event) {
    //     // Tutup semua dropdown selain yang sedang dibuka
    //     if (!$(event.target).closest(".dropdown-container").length) {
    //         $(this).addClass("hidden");
    //         console.log("test");
    //     }
    // });

    // Toggle dropdown yang dipilih
    $("#dropdownMenu-" + id).toggleClass("hidden");
};

$(function () {
    $(document).on("click", function (event) {
        // Cek apakah klik terjadi di luar dropdown
        if (!$(event.target).closest(".dropdown-container").length) {
            // Sembunyikan semua dropdown yang terbuka
            let dropdown = $(".dropdown-p");

            dropdown.each(function () {
                if (!$(this).hasClass("hidden")) {
                    $(this).addClass("hidden");
                    console.log("haha");
                }
            });
        }
    });
});

function activate(id) {
    const dropdown = document.getElementById(`dropdownMenu-${id}`);
    dropdown.classList.toggle("hidden");
}
