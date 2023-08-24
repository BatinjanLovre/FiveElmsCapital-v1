import DOM from "../dom-init";

function throttle(cb, delay = 250) {
    let shouldWait = false

    return (...args) => {
        if (shouldWait) return

        cb(...args)
        shouldWait = true
        setTimeout(() => {
            shouldWait = false
        }, delay)
    }
}

DOM.Methods.parallaxController = function ($this) {
    const el = $this[0];
    const FPS = 60;

    const elements = el.querySelectorAll(".parallax-scene .image-wrap");

    const parallax = throttle (function (event) {  
        elements.forEach(function (imageWrap) {
            const position = imageWrap.getAttribute("value");
            const x = (window.innerWidth - event.screenX * position) / 90;
            const y = (window.innerHeight - event.screenY * position) / 90;
            
            // imageWrap.style.transform = `translateX(${x}px) translateY(${y}px)`;
            
            gsap.to(imageWrap, {
                x: x,
                y: y,
                duration: 0.5,
            });
        });
    }, 1000 / FPS);

    
    class Box {
        constructor (width = 5, height = 7) {
            this.width = width;
            this.height = height;
            this.depth = 44;
        }

        // functions
        getArea () {
            return this.width * this.height;
        }
    }
    
    var test = function () {
        console.log("test", this);
    }

    test();
    window.addEventListener("mousemove", parallax);
};
