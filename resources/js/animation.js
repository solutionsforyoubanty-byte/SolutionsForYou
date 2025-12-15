import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// Section Fade + Lift animation
export function initAnimations() {
    gsap.utils.toArray("section").forEach((sec) => {
        gsap.from(sec, {
            opacity: 0,
            y: 60,
            duration: 1.2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: sec,
                start: "top 80%",
            }
        });
    });

    // Heading animations
    gsap.from(".heading-title, .heading-subtitle", {
        opacity: 0,
        y: 40,
        duration: 1,
        stagger: 0.2,
        scrollTrigger: {
            trigger: ".heading-title",
            start: "top 90%",
        }
    });
}
