document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menuToggle");
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.querySelector(".main-content");

  const savedState = localStorage.getItem("adminSidebarOpen");
  let sidebarOpen = savedState === "true";

  sidebar.classList.add("no-anim");
  mainContent.classList.add("no-anim");

  if (window.innerWidth > 768) {
    if (sidebarOpen) {
      sidebar.classList.remove("closed");
      mainContent.classList.remove("sidebar-closed");
    } else {
      sidebar.classList.add("closed");
      mainContent.classList.add("sidebar-closed");
    }
  } else {
    sidebar.classList.remove("active");
  }

  requestAnimationFrame(() => {
    sidebar.classList.remove("no-anim");
    mainContent.classList.remove("no-anim");
  });

  menuToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    sidebarOpen = !sidebarOpen;

    // Save state to localStorage
    localStorage.setItem("adminSidebarOpen", sidebarOpen);

    if (window.innerWidth > 768) {
      if (sidebarOpen) {
        sidebar.classList.remove("closed");
        mainContent.classList.remove("sidebar-closed");
      } else {
        sidebar.classList.add("closed");
        mainContent.classList.add("sidebar-closed");
      }
    } else {
      sidebar.classList.toggle("active");
    }
  });

  document.addEventListener("click", function (event) {
    if (window.innerWidth <= 768) {
      if (
        !event.target.closest(".sidebar") &&
        !event.target.closest(".menu-toggle")
      ) {
        sidebar.classList.remove("active");
      }
    }
  });

  window.addEventListener("resize", function () {
    if (window.innerWidth > 768) {
      sidebar.classList.remove("active");
      if (!sidebarOpen) {
        sidebar.classList.add("closed");
        mainContent.classList.add("sidebar-closed");
      }
    }
  });

  const currentPage = window.location.pathname.split("/").pop();
  const menuItems = document.querySelectorAll(".sidebar-menu a");
  menuItems.forEach((item) => {
    const href = item.getAttribute("href");
    if (
      href.includes(currentPage) ||
      (currentPage === "" && href.includes("dashboard"))
    ) {
      item.classList.add("active");
    } else {
      item.classList.remove("active");
    }
  });
});
