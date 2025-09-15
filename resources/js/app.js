import './bootstrap';
import './alpine-plugins';

import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


document.querySelectorAll('.swiper-slide video').forEach(video => {
    video.addEventListener('loadedmetadata', () => {
        const duration = Math.ceil(video.duration * 1000);
        video.closest('.swiper-slide').setAttribute('data-swiper-autoplay', duration);
    });
});

document.querySelectorAll('.swiper-slide iframe[src*="vimeo.com"]').forEach(iframe => {
    const player = new Vimeo.Player(iframe);
    player.getDuration().then(duration => {
        const ms = Math.ceil(duration * 1000);
        iframe.closest('.swiper-slide').setAttribute('data-swiper-autoplay', ms);
    });
});

// Specific initialization for the banner Swiper on the about page
const mySwiper = new Swiper('.mySwiper', {
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    on: {
        // Event when the slide transition starts
        slideChangeTransitionStart: function () {
            // Pause all videos and Vimeo iframes in all slides
            this.slides.forEach(slide => {
                const video = slide.querySelector('video');
                if (video) {
                    video.pause();
                }

                const iframe = slide.querySelector('iframe[src*="vimeo.com"]');
                if (iframe) {
                    const player = new Vimeo.Player(iframe);
                    player.pause();
                }

                /*
                // To restart CSS animations, remove animation classes from all elements
                // This assumes your animated elements have a class like '.animated-element'
                // and animation classes from a library like Animate.css
                const animatedElements = slide.querySelectorAll('.animated-element');
                animatedElements.forEach(el => {
                    // You might need to store the animation name in a data attribute
                    // e.g., data-animation="fadeInUp"
                    // and remove all 'animate__' classes.
                });
                */
            });
        },
        // Event when the slide transition ends
        slideChangeTransitionEnd: function () {
            // Play the video in the currently active slide
            const activeSlide = this.slides[this.activeIndex];
            const activeVideo = activeSlide.querySelector('video');
            if (activeVideo) {
                activeVideo.play();
            }

            // Play the Vimeo video in the currently active slide
            const activeIframe = activeSlide.querySelector('iframe[src*="vimeo.com"]');
            if (activeIframe) {
                const player = new Vimeo.Player(activeIframe);
                player.play();
            }

            /*
            // To restart CSS animations, add animation classes to the active slide's elements
            const animatedElements = activeSlide.querySelectorAll('.animated-element');
            animatedElements.forEach(el => {
                // Add back the animation classes
                // e.g., el.classList.add('animate__animated', 'animate__' + el.dataset.animation);
            });
            */
        },
    }
});

// You might need to add the Vimeo Player API script to your page if it's not already there
// <script src="https://player.vimeo.com/api/player.js"></script>



// resources/js/app.js
function toggleTheme()
{
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    {
        // 切換到淺色主題
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-theme', 'light'); //for DaisyUI
        localStorage.theme = 'light';
    }
    else
    {
        // 切換到深色主題
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-theme', 'dark'); //for DaisyUI
        localStorage.theme = 'dark';
    }
}

// 頁面載入時設置主題
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
{
    document.documentElement.classList.add('dark');
    document.documentElement.setAttribute('data-theme', 'dark'); //for DaisyUI
}
else
{
    document.documentElement.classList.remove('dark');
    document.documentElement.setAttribute('data-theme', 'light'); //for DaisyUI
}

// 將函數放到全域
window.toggleTheme = toggleTheme;
