document.addEventListener("DOMContentLoaded", () => {
    const toggleSidebar = document.getElementById("toggleSidebar")
    const sidebar = document.getElementById("sidebar")
    const toggleSidebarIcon = document.getElementById("toggleSidebarIcon")
    const userMenuButton = document.getElementById("user-menu-button")
    const userDropdown = document.getElementById("user-dropdown")

    // Toggle sidebar on mobile
    toggleSidebar.addEventListener("click", () => {
        sidebar.classList.toggle("-translate-x-full")
        toggleSidebarIcon.classList.toggle("rotate-180")
    })

    // Toggle user menu dropdown
    userMenuButton.addEventListener("click", () => {
        userDropdown.classList.toggle("hidden")
    })

    // Close user menu when clicking outside
    document.addEventListener("click", (event) => {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add("hidden")
        }
    })

    // Toggle submenu in sidebar
    const submenuToggles = document.querySelectorAll("[data-collapse-toggle]")
    submenuToggles.forEach((toggle) => {
        toggle.addEventListener("click", function () {
            const targetId = this.getAttribute("data-collapse-toggle")
            const targetElement = document.getElementById(targetId)
            targetElement.classList.toggle("hidden")
        })
    })
})

