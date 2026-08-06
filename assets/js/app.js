/* ==========================================
   JobAlertHub - app.js
   ========================================== */

document.addEventListener("DOMContentLoaded", function () {

    // ==========================
    // Sticky Navbar Shadow
    // ==========================

    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", function () {

        if (window.scrollY > 30) {

            navbar.classList.add("shadow");

        } else {

            navbar.classList.remove("shadow");

        }

    });


    // ==========================
    // Scroll To Top
    // ==========================

    const scrollBtn = document.getElementById("scrollTop");

    if (scrollBtn) {

        window.addEventListener("scroll", () => {

            if (window.scrollY > 300) {

                scrollBtn.classList.add("show");

            } else {

                scrollBtn.classList.remove("show");

            }

        });

        scrollBtn.addEventListener("click", () => {

            window.scrollTo({

                top: 0,

                behavior: "smooth"

            });

        });

    }


    // ==========================
    // Counter Animation
    // ==========================

    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {

        counter.innerText = "0";

        const update = () => {

            const target = +counter.getAttribute("data-target");

            const current = +counter.innerText;

            const increment = target / 100;

            if (current < target) {

                counter.innerText = Math.ceil(current + increment);

                setTimeout(update, 20);

            } else {

                counter.innerText = target;

            }

        };

        update();

    });


    // ==========================
    // Dark Mode
    // ==========================

    const darkBtn = document.getElementById("darkMode");

    if (darkBtn) {

        darkBtn.addEventListener("click", () => {

            document.body.classList.toggle("dark-mode");

            localStorage.setItem(

                "theme",

                document.body.classList.contains("dark-mode")
                    ? "dark"
                    : "light"

            );

        });

    }

    if (localStorage.getItem("theme") === "dark") {

        document.body.classList.add("dark-mode");

    }

});