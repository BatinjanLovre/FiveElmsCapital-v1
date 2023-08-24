import DOM from "../dom-init";

DOM.Methods.menuControl = function ($this) {
    const menu = $this[0];
    const menuTriggerButton = document.querySelector(".mobile-menu-trigger");

    let isMenuOpen = false;

    // utility functions
    function open () {
        document.body.classList.add("menu-open");
        menuTriggerButton.classList.add("active");
    }

    function close () {
        document.body.classList.remove("menu-open");
        menuTriggerButton.classList.remove("active");
    }

    // add events (click, mouseover, keydown ...)
    menuTriggerButton.addEventListener("click", function () {
        if (isMenuOpen) {
            isMenuOpen = false;
            close();
        }
        else {
            isMenuOpen = true;
            open();
        }
    });
};
