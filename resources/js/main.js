document.addEventListener("DOMContentLoaded", function () {
    /**
     * Mobile menu
     */
    const burgerMenu = document.querySelector("#burgerMenu");
    const mobileMenu = document.querySelector("#mobileMenu");
    const mobileMenuNavLink = mobileMenu.querySelectorAll("nav > a");
    const closeMobileMenu = document.querySelector("#closeMobileMenu");

    function toggleMobileMenu() {
        mobileMenu.classList.toggle("hidden");
    }

    burgerMenu.addEventListener("click", function (event) {
        toggleMobileMenu();
    });

    closeMobileMenu.addEventListener("click", function (event) {
        toggleMobileMenu();
    });

    mobileMenuNavLink.forEach(function (el) {
        el.addEventListener("click", function (event) {
            toggleMobileMenu();
        });
    });

    /**
     * Accordion
     */
    const accordionHeader = document.querySelectorAll(".accordion-header");

    accordionHeader.forEach((header) => {
        header.addEventListener("click", function () {
            const accordionContent =
                header.parentElement.querySelector(".accordion-content");
            // let accordionMaxHeight = accordionContent.style.maxHeight;

            // Condition handling
            if (accordionContent.classList.contains("hidden")) {
                accordionContent.classList.remove("hidden");
                header.classList.add("_is-toggled");
            } else {
                accordionContent.classList.add("hidden");
                header.classList.remove("_is-toggled");
            }
        });
    });

    /**
     * Anchor smooth scroll
     */
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
            });
        });
    });

    let quantity = document.querySelectorAll("#quantity");
    let plus = document.querySelectorAll("#plus");
    let minus = document.querySelectorAll("#minus");
    let form = document.querySelectorAll("#cart-form");

    // console.log();

    function quantityIncrement(i) {
        quantity[i].value = parseInt(quantity[i].value) + 1;
    }

    function quantityDecrement(i) {
        if (quantity[i].value > 1) {
            quantity[i].value = parseInt(quantity[i].value) - 1;
        }
    }

    function quantityButtonsAddEventListeners(buttons) {
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener("click", function (event) {
                this.id == 'plus' ? quantityIncrement(i) : quantityDecrement(i);

                event.stopImmediatePropagation();

                if (i < form.length) {
                    form[i].submit();
                }
            });
        }
    }

    quantityButtonsAddEventListeners(plus);
    quantityButtonsAddEventListeners(minus);
});
