(function () {
    "use strict"; // Enforces stricter parsing and error handling in the code.

    // ======= Sticky Navbar =======
    window.onscroll = function () {
        const ud_header = document.querySelector(".ud-header"); // Selects the header element.
        const sticky = ud_header.offsetTop; // Stores the initial top offset of the header.
        const logo = document.querySelectorAll(".header-logo"); // Selects all elements with the class .header-logo.
        const text_header = document.querySelector(".header-text"); // Selects the header text element.

        // Adds the 'sticky' class to the header when the page is scrolled past its original position.
        if (window.scrollY > sticky) {
            ud_header.classList.add("sticky"); // Adds the 'sticky' class when scrolled.
        } else {
            ud_header.classList.remove("sticky"); // Removes the 'sticky' class when scrolled back up.
        }

        // Toggles text color based on whether the header is sticky.
        if (ud_header.classList.contains("sticky")) {
            text_header.classList.add("text-dark"); // Adds dark text color in sticky mode.
            text_header.classList.add("dark:text-white"); // Adds white text color in dark mode.
            text_header.classList.remove("text-white"); // Removes white text in normal mode.
        } else {
            text_header.classList.add("text-white"); // Reverts to white text when not sticky.
            text_header.classList.remove("text-dark"); // Removes dark text color.
        }

        // Logo image change based on the sticky state of the header.
        if (logo.length) {
            if (ud_header.classList.contains("sticky")) {
                document.querySelector(".header-logo").src =
                    "https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png"; // Changes logo when sticky.
            } else {
                document.querySelector(".header-logo").src =
                    "https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png"; // Reverts logo when not sticky.
            }
        }

        // Changes logo for dark mode when the header is sticky.
        if (document.documentElement.classList.contains("dark")) {
            if (logo.length) {
                if (ud_header.classList.contains("sticky")) {
                    document.querySelector(".header-logo").src =
                        "https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png"; // Logo change for dark sticky mode.
                }
            }
        }

        // Show or hide the "back-to-top" button based on scroll position.
        const backToTop = document.querySelector(".back-to-top");
        if (
            document.body.scrollTop > 50 ||
            document.documentElement.scrollTop > 50
        ) {
            backToTop.style.display = "flex"; // Shows button if scrolled more than 50px.
        } else {
            backToTop.style.display = "none"; // Hides button if scrolled less than 50px.
        }
    };

    // ===== URL-based header style =====
    function updateHeaderBasedOnURL() {
        const ud_header = document.querySelector(".ud-header"); // Selects the header element.
        const currentPath = window.location.pathname; // Gets the current URL path.

        // Check if the URL is /sekolah/peta
        if (currentPath === "/sekolah/peta") {
            ud_header.classList.add("bg-primary"); // Adds bg-primary class.
            ud_header.classList.remove("bg-transparent"); // Removes bg-transparent class.
        } else {
            ud_header.classList.remove("bg-primary"); // Removes bg-primary class.
            ud_header.classList.add("bg-transparent"); // Adds bg-transparent class.
        }
    }

    // Call the function to update header styles based on the URL
    updateHeaderBasedOnURL();

    // ===== Responsive Navbar =====
    let navbarToggler = document.querySelector("#navbarToggler"); // Selects the navbar toggle button.
    const navbarCollapse = document.querySelector("#navbarCollapse"); // Selects the collapsible navbar content.

    navbarToggler.addEventListener("click", () => {
        navbarToggler.classList.toggle("navbarTogglerActive"); // Toggles active class for the navbar toggle button.
        navbarCollapse.classList.toggle("hidden"); // Shows or hides the navbar content.
    });

    // ===== Close navbar on link click =====
    document
        .querySelectorAll("#navbarCollapse ul li:not(.submenu-item) a")
        .forEach((e) =>
            e.addEventListener("click", () => {
                navbarToggler.classList.remove("navbarTogglerActive"); // Removes active state when a link is clicked.
                navbarCollapse.classList.add("hidden"); // Hides the navbar after a link is clicked.
            })
        );

    // ===== Sub-menu Toggle =====
    const submenuItems = document.querySelectorAll(".submenu-item"); // Selects all submenu items.
    submenuItems.forEach((el) => {
        el.querySelector("a").addEventListener("click", () => {
            el.querySelector(".submenu").classList.toggle("hidden"); // Toggles visibility of the submenu when clicked.
        });
    });

    // ===== FAQ Accordion =====
    const faqs = document.querySelectorAll(".single-faq"); // Selects all FAQ items.
    faqs.forEach((el) => {
        el.querySelector(".faq-btn").addEventListener("click", () => {
            el.querySelector(".icon").classList.toggle("rotate-180"); // Rotates the icon when the FAQ is opened.
            el.querySelector(".faq-content").classList.toggle("hidden"); // Toggles visibility of the FAQ content.
        });
    });

    // ===== Initialize WOW.js for animations =====
    new WOW().init(); // Initializes the WOW.js library for scroll animations.

    // ===== Scroll to Top Functionality =====
    function scrollTo(element, to = 0, duration = 500) {
        const start = element.scrollTop; // Gets the current scroll position.
        const change = to - start; // Calculates the distance to scroll.
        const increment = 20; // Time increment for each frame of the animation.
        let currentTime = 0; // Tracks current animation time.

        const animateScroll = () => {
            currentTime += increment; // Increases the time for each frame.

            const val = Math.easeInOutQuad(
                currentTime,
                start,
                change,
                duration
            ); // Calculates the next scroll position.

            element.scrollTop = val; // Sets the scroll position.

            if (currentTime < duration) {
                setTimeout(animateScroll, increment); // Continues the animation until the duration is met.
            }
        };

        animateScroll(); // Starts the scroll animation.
    }

    // Ease-in-out function for smooth scrolling.
    Math.easeInOutQuad = function (t, b, c, d) {
        t /= d / 2;
        if (t < 1) return (c / 2) * t * t + b;
        t--;
        return (-c / 2) * (t * (t - 2) - 1) + b;
    };

    // Scrolls to the top when the "back-to-top" button is clicked.
    document.querySelector(".back-to-top").onclick = () => {
        scrollTo(document.documentElement); // Smoothly scrolls to the top of the document.
    };

    /* ========  Theme Switcher Functionality ======== */

    // Selects the theme switcher button.
    const themeSwitcher = document.getElementById("themeSwitcher");

    // Retrieves the user's saved theme preference from localStorage.
    const userTheme = localStorage.getItem("theme");
    // Checks the system's preferred color scheme (light or dark).
    const systemTheme = window.matchMedia(
        "(prefers-color0scheme: dark)"
    ).matches;

    // Initial theme check based on user or system preference.
    const themeCheck = () => {
        if (userTheme === "dark" || (!userTheme && systemTheme)) {
            document.documentElement.classList.add("dark"); // Sets dark theme if user or system prefers dark.
            return;
        }
    };

    // Manual theme switching when the button is clicked.
    const themeSwitch = () => {
        if (document.documentElement.classList.contains("dark")) {
            document.documentElement.classList.remove("dark"); // Switches to light theme.
            localStorage.setItem("theme", "light"); // Saves user preference as light theme.
            return;
        }

        document.documentElement.classList.add("dark"); // Switches to dark theme.
        localStorage.setItem("theme", "dark"); // Saves user preference as dark theme.
    };

    // Adds event listener to the theme switcher button to toggle the theme.
    themeSwitcher.addEventListener("click", () => {
        themeSwitch();
    });

    // Calls the themeCheck function to apply the theme on initial page load.
    themeCheck();

    /* ========  Theme Switcher End ======== */
})();
