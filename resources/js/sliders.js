import Swiper from 'swiper';
import { Autoplay, EffectFade, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const initSliders = () => {
    document.querySelectorAll('[data-swiper]').forEach((el) => {
        if (el.swiper) return;
        const isHero = el.dataset.swiper === 'hero';
        const slideCount = el.querySelectorAll('.swiper-slide').length;
        new Swiper(el, {
            modules: [Autoplay, EffectFade, Navigation, Pagination],
            loop: slideCount > 1,
            speed: prefersReducedMotion() ? 0 : 900,
            effect: isHero ? 'fade' : 'slide',
            autoplay: isHero && !prefersReducedMotion() && slideCount > 1 ? {
                delay: 5200,
                disableOnInteraction: false,
            } : false,
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });
};

document.addEventListener('DOMContentLoaded', initSliders);
document.addEventListener('livewire:navigated', initSliders);
