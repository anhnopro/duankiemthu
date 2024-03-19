const body = document.querySelector("body");
const darkLight = document.querySelector("#hd-admin-darkLight");
const sidebar = document.querySelector(".hd-admin-sidebar");
const submenuItems = document.querySelectorAll(".hd-admin-submenu-header_item");
const sidebarOpen = document.querySelector("#hd-admin-sidebarOpen");
const sidebarClose = document.querySelector(".hd-admin-collapse_sidebar");
const sidebarExpand = document.querySelector(".hd-admin-expand_sidebar");

sidebarOpen.addEventListener("click", () => sidebar.classList.toggle("close"));

darkLight.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        darkLight.classList.replace("bx-sun", "bx-moon");
    } else {
        darkLight.classList.replace("bx-moon", "bx-sun");
    }
});

submenuItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        item.classList.toggle("show_hd-admin_submenu");
        submenuItems.forEach((item2, index2) => {
            if (index !== index2) {
                item2.classList.remove("show_hd-admin_submenu");
            }
        });
    });
});

if (window.innerWidth < 768) {
    sidebar.classList.add("close");
} else {
    sidebar.classList.remove("close");
}
