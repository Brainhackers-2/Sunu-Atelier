import './bootstrap';

// ─── Alpine.js ───────────────────────────────────────────────────
import Alpine from 'alpinejs';
import focus   from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus);
Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

// ─── GSAP + ScrollTrigger ─────────────────────────────────────────
import { gsap }         from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);
window.gsap          = gsap;
window.ScrollTrigger = ScrollTrigger;

// ─── Swiper ───────────────────────────────────────────────────────
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, FreeMode } from 'swiper/modules';
Swiper.use([Navigation, Pagination, Autoplay, FreeMode]);
window.Swiper = Swiper;

// ─── Chart.js ─────────────────────────────────────────────────────
import Chart from 'chart.js/auto';
window.Chart = Chart;

// ─── Lucide Icons (tree-shakeable) ───────────────────────────────
import { createIcons, icons } from 'lucide';
document.addEventListener('DOMContentLoaded', () => createIcons({ icons }));
