document.addEventListener('DOMContentLoaded', () => {
    // Mobile Sidebar Functionality
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
  
    // Open sidebar
    mobileMenuToggle.addEventListener('click', () => {
        mobileSidebar.classList.remove('translate-x-full');
        sidebarOverlay.classList.remove('invisible');
        sidebarOverlay.classList.remove('opacity-0');
        sidebarOverlay.classList.add('opacity-50');
    });

    // Close sidebar
    const closeSidebar = () => {
        mobileSidebar.classList.add('translate-x-full');
        sidebarOverlay.classList.add('opacity-0');
        setTimeout(() => {
            sidebarOverlay.classList.add('invisible');
        }, 300);
    };

    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Scroller Functionality
    const scroller = document.querySelector(".scroller");
    if (scroller && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        scroller.setAttribute("data-animated", true);
        const scrollerInner = scroller.querySelector(".scroller__inner");
        
        if (scrollerInner) {
            const items = Array.from(scrollerInner.children);
            items.forEach((item) => {
                const clone = item.cloneNode(true);
                clone.setAttribute("aria-hidden", true);
                scrollerInner.appendChild(clone);
            });
        }
    }
});