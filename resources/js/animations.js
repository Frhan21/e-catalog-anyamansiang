import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

let animationContext;

const cleanupAnimations = () => {
    animationContext?.revert();
    animationContext = null;
    document.querySelectorAll('[data-counter-value]').forEach((el) => {
        el.textContent = el.dataset.counterValue;
    });
};

const initAnimations = () => {
    cleanupAnimations();
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    animationContext = gsap.context(() => {
        document.querySelectorAll('[data-counter-value]').forEach((el) => {
            const original = el.dataset.counterValue;
            const match = original.match(/^([^0-9]*)(-?\d+(?:[.,]\d+)?)(.*)$/);
            if (!match) return;

            const [, prefix, rawValue, suffix] = match;
            const target = Number(rawValue.replace(',', '.'));
            if (!Number.isFinite(target)) return;

            const decimals = (rawValue.match(/[.,](\d+)$/)?.[1] ?? '').length;
            const format = (value) => `${prefix}${value.toFixed(decimals)}${suffix}`;
            const counter = { value: 0 };

            gsap.to(counter, {
                value: target,
                duration: 1.6,
                ease: 'power2.out',
                snap: { value: decimals > 0 ? 10 ** -decimals : 1 },
                onStart: () => {
                    el.textContent = format(0);
                },
                onUpdate: () => {
                    el.textContent = format(counter.value);
                },
                onComplete: () => {
                    el.textContent = original;
                },
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%',
                    once: true,
                },
            });
        });

        document.querySelectorAll('[data-animate]').forEach((el, index) => {
            gsap.fromTo(el,
                { autoAlpha: 0, y: 28 },
                {
                    autoAlpha: 1,
                    y: 0,
                    duration: 0.75,
                    delay: Math.min(index * 0.08, 0.32),
                    ease: 'power3.out',
                    scrollTrigger: el.dataset.animate === 'load' ? false : {
                        trigger: el,
                        start: 'top 86%',
                        once: true,
                    },
                }
            );
        });
    });
};

document.addEventListener('DOMContentLoaded', initAnimations);
document.addEventListener('livewire:navigating', cleanupAnimations);
document.addEventListener('livewire:navigated', initAnimations);
