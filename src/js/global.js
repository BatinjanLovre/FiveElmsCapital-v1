import DOM from "./dom-init";
import Swup from "swup";

let smoother;

window.addEventListener("load", function () {
    gsap.registerPlugin(ScrollTrigger, ScrollSmoother, CustomEase);
    loadHandle();
});


// functions
function initSmoother () {
    if (window.innerWidth >= 767) {
        smoother = ScrollSmoother.create({
            smooth: 1.2,
            smoothTouch: false,
            effects: true,
        });
        
        window.smoother = smoother;
    }
}

function loadHandle () {
    ScrollTrigger.refresh();
    // whatever needs to go after scrollsmoother
    setTimeout(() => {
        DOM.onReady();
    }, 150);

    setTimeout(function () {
        document.body.classList.add("loaded");
    }, 300);
}

/* instance swup */
const swup = new Swup();
swup.on('pageView', () => {
    // This runs after every page change
    console.log("adasd");
    loadHandle();
});