import DOM from "../dom-init";

DOM.Methods.slider = function ($this) {

    // targetiranje
    const el = $this[0];
    const splideEl = el.querySelector(".splide");

    const prevBtn = el.querySelector(".btn.prev");
    const nextBtn = el.querySelector(".btn.next");
    // targetiranje


    // init plugina na targetiran element s nekim opcijama
    const splideSlider = new Splide(splideEl, {
        arrows: false,
        gap: "0.4rem",
        perPage: 3,
        perMove: 1,
        speed: 1000,
        pagination: false
    });

    splideSlider.mount();
    // init plugina na targetiran element s nekim opcijama

    
    // dodavanje user kontrole (klik miša u ovom slučaju)
    // add event listeners
    prevBtn.addEventListener("click", function () {
        splideSlider.go("<");
    });

    nextBtn.addEventListener("click", function () {
        splideSlider.go(">");
    });
    // dodavanje user kontrole (klik miša u ovom slučaju)
};