import DOM from "../dom-init";

DOM.Methods.teamCardsControl = function ($this) {
    const el = $this[0];

    const cards = el.querySelectorAll(".card");

    const anim = gsap.fromTo(cards, {
        x: 100,
        opacity: 0
    }, {
        x: 0,
        opacity: 1,
        duration: 1,
        paused: true,
        stagger: 0.05,
        ease: "power3.inOut",
        scrollTrigger: {
            trigger: el,
            start: "top bottom",
            end: "bottom bottom",
            // markers: true,
            scrub: true,
        }
    });
};
