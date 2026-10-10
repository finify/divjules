import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

const reduce = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const fine = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;
const EASE = 'power4.out';

/* ---------------------------------------------------------------
   Smooth (inertial) scrolling, driven by GSAP's ticker so ScrollTrigger
   scrubs stay perfectly in sync. Skipped for reduced motion.
---------------------------------------------------------------- */
export let lenis = null;
function initLenis() {
    if (lenis || reduce()) return;
    lenis = new Lenis({
        duration: 1.15,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        // let modals, menus and inner scrollers keep native scrolling
        prevent: (node) => !!node.closest?.('.review-modal, .video-modal, #mobile-menu, .overflow-y-auto, .overflow-auto, [data-lenis-prevent], select'),
    });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    // pause smooth scrolling while a modal locks the page
    const wrap = (name, fn) => {
        const orig = window[name];
        if (typeof orig !== 'function' || orig.__wrapped) return;
        window[name] = function (...args) { const r = orig.apply(this, args); fn(); return r; };
        window[name].__wrapped = true;
    };
    wrap('openVideoModal', () => lenis.stop());
    wrap('openReviewModal', () => lenis.stop());
    wrap('closeVideoModal', () => lenis.start());
    wrap('closeReviewModal', () => lenis.start());
}

/* ---------------------------------------------------------------
   Header: scrolled state, hide on scroll down, scroll progress bar
---------------------------------------------------------------- */
function initNav() {
    const nav = document.querySelector('[data-site-nav]');
    const bar = document.querySelector('.scroll-progress');
    if (!nav) return;
    let last = window.scrollY;
    const onScroll = () => {
        const y = window.scrollY;
        nav.classList.toggle('is-scrolled', y > 8);
        // transparent header with light text while it sits over a navy page hero
        const first = document.querySelector('main > div > section, main > section');
        nav.classList.toggle('on-dark', !!first?.classList.contains('page-hero') && y < first.offsetHeight - 80);
        const menuOpen = document.getElementById('mobile-menu')?.classList.contains('is-open');
        // pages with sticky filter bars keep the header pinned so the bars never float under a gap
        const canHide = !document.querySelector('main .sticky');
        // keep the header pinned while a search is docked in it
        const docked = nav.classList.contains('has-search');
        if (canHide) nav.classList.toggle('is-hidden', y > 300 && y > last + 4 && !menuOpen && !docked);
        if (y < last - 4) nav.classList.remove('is-hidden');
        last = y;
        if (bar) {
            const max = document.documentElement.scrollHeight - innerHeight;
            bar.style.transform = `scaleX(${max > 0 ? y / max : 0})`;
        }
    };
    window.removeEventListener('scroll', initNav.handler);
    initNav.handler = onScroll;
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ---------------------------------------------------------------
   Mobile menu with staggered links
---------------------------------------------------------------- */
function initMobileMenu() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu || btn.dataset.bound) return;
    btn.dataset.bound = '1';
    const panel = menu.querySelector('[data-menu-panel]');
    const bg = menu.querySelector('[data-menu-bg]');
    const items = menu.querySelectorAll('[data-menu-item]');
    let open = false;
    gsap.set(panel, { xPercent: 100 });

    // one reversible timeline: panel slides in from the right, links cascade after it
    const tl = gsap.timeline({ paused: true, defaults: { ease: 'expo.out' } })
        .to(bg, { opacity: 1, duration: 0.4, ease: 'power2.out' }, 0)
        .fromTo(panel, { xPercent: 100 }, { xPercent: 0, duration: 0.85 }, 0)
        .fromTo(items, { x: 60, opacity: 0 }, { x: 0, opacity: 1, duration: 0.9, stagger: 0.05 }, 0.18)
        .eventCallback('onReverseComplete', () => menu.classList.remove('is-open'));
    if (reduce()) tl.duration(0.01);

    const set = (state) => {
        if (state === open) return;
        open = state;
        btn.setAttribute('aria-expanded', state);
        menu.setAttribute('aria-hidden', !state);
        if (state) {
            menu.classList.add('is-open');
            lenis?.stop();
            document.documentElement.style.overflow = 'hidden';
            tl.timeScale(1).play();
            menu.querySelector('[data-menu-close]')?.focus({ preventScroll: true });
        } else {
            lenis?.start();
            document.documentElement.style.overflow = '';
            tl.timeScale(1.6).reverse();
            btn.focus({ preventScroll: true });
        }
    };
    btn.addEventListener('click', () => set(!open));
    menu.querySelector('[data-menu-close]')?.addEventListener('click', () => set(false));
    bg?.addEventListener('click', () => set(false));
    menu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => set(false)));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') set(false); });
}

/* ---------------------------------------------------------------
   Split headline into words that rise in
---------------------------------------------------------------- */
function splitWords(el) {
    if (el.dataset.splitDone) return el.querySelectorAll('.split-line > span');
    el.dataset.splitDone = '1';
    const walk = (node) => {
        [...node.childNodes].forEach((child) => {
            if (child.nodeType === 3) {
                const frag = document.createDocumentFragment();
                child.textContent.split(/(\s+)/).forEach((part) => {
                    if (!part) return;
                    if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
                    const outer = document.createElement('span');
                    outer.className = 'split-line';
                    outer.style.display = 'inline-block';
                    const inner = document.createElement('span');
                    inner.textContent = part;
                    outer.appendChild(inner);
                    frag.appendChild(outer);
                });
                child.replaceWith(frag);
            } else if (child.nodeType === 1 && !child.matches('.word-swap, i, br')) {
                walk(child);
            }
        });
    };
    walk(el);
    return el.querySelectorAll('.split-line > span');
}

function initSplit() {
    document.querySelectorAll('[data-split], .page-hero h1').forEach((el) => {
        if (el.dataset.splitAnimated) return;
        el.dataset.splitAnimated = '1';
        const words = splitWords(el);
        if (reduce()) return;
        gsap.fromTo(words, { yPercent: 115, rotate: 4 }, { yPercent: 0, rotate: 0, duration: 1.4, ease: 'expo.out', stagger: 0.06, delay: Number(el.dataset.delay || 0.1) });
    });
    document.querySelectorAll('.page-hero h1 ~ p, .page-hero h1 + *').forEach((el) => {
        if (el.dataset.introDone || reduce()) return;
        el.dataset.introDone = '1';
        gsap.from(el, { y: 20, opacity: 0, duration: 0.9, ease: EASE, delay: 0.45 });
    });
}

/* ---------------------------------------------------------------
   Scroll reveals
   - explicit: [data-reveal] (optionally grouped by [data-reveal-group])
   - automatic: headings / grid items / images inside inner-page sections
---------------------------------------------------------------- */
function initReveals() {
    if (reduce()) return;
    const explicit = gsap.utils.toArray('[data-reveal]:not([data-revealed])');
    explicit.forEach((el) => el.setAttribute('data-revealed', ''));
    ScrollTrigger.batch(explicit, {
        start: 'top 90%',
        once: true,
        onEnter: (batch) => gsap.fromTo(batch,
            { opacity: 0, y: (i, el) => Number(el.dataset.revealY || 36), scale: (i, el) => (el.dataset.reveal === 'scale' ? 0.94 : 1) },
            { opacity: 1, y: 0, scale: 1, duration: 1.3, ease: EASE, stagger: 0.09, clearProps: 'transform' }),
    });

    // Automatic reveals for pages that weren't hand-annotated
    const auto = [];
    document.querySelectorAll('main section:not(.page-hero):not([data-no-auto])').forEach((section) => {
        if (section.querySelector('[data-reveal]')) return;
        section.querySelectorAll('h2, .grid > *, form, img, .card-hover, table').forEach((el) => {
            if (el.closest('[data-auto-revealed]') || el.closest('.hidden') || el.dataset.autoRevealed) return;
            el.dataset.autoRevealed = '';
            auto.push(el);
        });
    });
    auto.forEach((el) => {
        if (el.getBoundingClientRect().top < innerHeight * 0.95) return; // already on screen: leave it be
        gsap.set(el, { opacity: 0, y: 32 });
    });
    ScrollTrigger.batch(auto.filter((el) => el.getBoundingClientRect().top >= innerHeight * 0.95), {
        start: 'top 92%',
        once: true,
        onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, duration: 1.2, ease: EASE, stagger: 0.08, clearProps: 'transform,opacity' }),
    });
}

/* ---------------------------------------------------------------
   Count-up numbers: <span data-count="10000" data-suffix="+">
---------------------------------------------------------------- */
function initCounters() {
    document.querySelectorAll('[data-count]:not([data-counted])').forEach((el) => {
        el.setAttribute('data-counted', '');
        const end = Number(el.dataset.count);
        const suffix = el.dataset.suffix || '';
        const fmt = (v) => Math.round(v).toLocaleString() + suffix;
        if (reduce()) { el.textContent = fmt(end); return; }
        el.textContent = fmt(0);
        const o = { v: 0 };
        ScrollTrigger.create({
            trigger: el, start: 'top 92%', once: true,
            onEnter: () => gsap.to(o, { v: end, duration: 2, ease: 'power3.out', onUpdate: () => (el.textContent = fmt(o.v)) }),
        });
    });
}

/* ---------------------------------------------------------------
   Parallax: [data-speed="0.2"] moves against scroll
---------------------------------------------------------------- */
function initParallax() {
    if (reduce()) return;
    document.querySelectorAll('[data-speed]:not([data-par])').forEach((el) => {
        el.setAttribute('data-par', '');
        const s = Number(el.dataset.speed);
        gsap.fromTo(el, { y: () => -s * 120 }, { y: () => s * 120, ease: 'none', scrollTrigger: { trigger: el.closest('section') || el, start: 'top bottom', end: 'bottom top', scrub: 1, invalidateOnRefresh: true } });
    });
}

/* ---------------------------------------------------------------
   Pointer interactions: magnetic buttons, 3D tilt cards, spotlight
---------------------------------------------------------------- */
function initPointer() {
    if (!fine() || reduce()) return;
    document.querySelectorAll('[data-magnetic]:not([data-mag])').forEach((el) => {
        el.setAttribute('data-mag', '');
        const xTo = gsap.quickTo(el, 'x', { duration: 0.5, ease: 'elastic.out(1, 0.4)' });
        const yTo = gsap.quickTo(el, 'y', { duration: 0.5, ease: 'elastic.out(1, 0.4)' });
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            xTo((e.clientX - r.left - r.width / 2) * 0.25);
            yTo((e.clientY - r.top - r.height / 2) * 0.35);
        });
        el.addEventListener('pointerleave', () => { xTo(0); yTo(0); });
    });

    const tiltTargets = document.querySelectorAll('[data-tilt]:not([data-tilted]), main .card-hover:not([data-tilted])');
    tiltTargets.forEach((el) => {
        el.setAttribute('data-tilted', '');
        const max = Number(el.dataset.tilt || 6);
        const rx = gsap.quickTo(el, 'rotationX', { duration: 0.9, ease: 'power3.out' });
        const ry = gsap.quickTo(el, 'rotationY', { duration: 0.9, ease: 'power3.out' });
        gsap.set(el, { transformPerspective: 900 });
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            const px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
            ry((px - 0.5) * max * 2);
            rx(-(py - 0.5) * max * 2);
            el.style.setProperty('--mx', `${px * 100}%`);
            el.style.setProperty('--my', `${py * 100}%`);
        });
        el.addEventListener('pointerleave', () => { rx(0); ry(0); });
    });

    document.querySelectorAll('[data-spotlight]:not([data-tilt])').forEach((el) => {
        if (el.dataset.spotBound) return;
        el.dataset.spotBound = '1';
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--mx', `${e.clientX - r.left}px`);
            el.style.setProperty('--my', `${e.clientY - r.top}px`);
        });
    });
}

/* ---------------------------------------------------------------
   Smooth anchor scrolling + back-to-top
---------------------------------------------------------------- */
function initAnchors() {
    document.querySelectorAll('a[href^="#"]:not([data-anc])').forEach((a) => {
        a.setAttribute('data-anc', '');
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href');
            if (id.length < 2) return;
            const t = document.querySelector(id);
            if (!t) return;
            e.preventDefault();
            if (lenis) lenis.scrollTo(t, { offset: -70, duration: 1.4 });
            else t.scrollIntoView({ behavior: reduce() ? 'auto' : 'smooth', block: 'start' });
        });
    });
    document.querySelectorAll('[data-scroll-top]').forEach((b) => {
        b.onclick = () => (lenis ? lenis.scrollTo(0, { duration: 1.6 }) : window.scrollTo({ top: 0, behavior: reduce() ? 'auto' : 'smooth' }));
    });
}

/* ---------------------------------------------------------------
   Three.js stages — loaded lazily so the 3D code never blocks paint
---------------------------------------------------------------- */
function webglOK() {
    try {
        const c = document.createElement('canvas');
        return !!(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
    } catch (e) { return false; }
}

export const stages = {};

function initThree() {
    if (!webglOK()) return;
    document.querySelectorAll('[data-three]:not([data-mounted])').forEach((el) => {
        el.setAttribute('data-mounted', '');
        const kind = el.dataset.three;
        if (kind !== 'globe') return;
        const load = import('./three/globe.js');
        load.then((mod) => {
            const api = mod.mountGlobe(el);
            if (el.id) stages[el.id] = api;
            el.dispatchEvent(new CustomEvent('three:ready', { detail: api }));
            gsap.fromTo(el, { opacity: 0 }, { opacity: 1, duration: 1.4, ease: 'power2.out' });
            const section = el.closest('section') || el.parentElement;
            ScrollTrigger.create({ trigger: section, start: 'top top', end: 'bottom top', onUpdate: (st) => api.setScroll(st.progress) });
        });
    });
}

export function initMotion() {
    document.documentElement.classList.add('js-motion');
    initLenis();
    initNav();
    initMobileMenu();
    initSplit();
    initReveals();
    initCounters();
    initParallax();
    initPointer();
    initAnchors();
    initThree();
    initImageZoom();
    initReadProgress();
    initDockSearch();
    requestAnimationFrame(() => ScrollTrigger.refresh());
}

export { gsap, ScrollTrigger, reduce, fine, EASE };

/* ---------------------------------------------------------------
   Search bars dock into the header once the page's filter bar
   ([data-dock-search]) scrolls away; both inputs stay in sync.
---------------------------------------------------------------- */
function initDockSearch() {
    const nav = document.querySelector('[data-site-nav]');
    const dock = nav?.querySelector('[data-nav-search]');
    const bar = document.querySelector('[data-dock-search]');
    initDockSearch.trigger?.kill();
    nav?.classList.remove('has-search');
    if (!nav || !dock || !bar) return;

    const proxy = dock.querySelector('[data-nav-search-input]');
    const source = () => bar.querySelector('input[type=search]');
    if (!source()) return;
    proxy.placeholder = source().placeholder || 'Search…';
    proxy.value = source().value;

    if (!dock.dataset.bound) {
        dock.dataset.bound = '1';
        // header → page: Livewire listens for "input" on the original field
        proxy.addEventListener('input', () => {
            const src = source();
            if (!src) return;
            src.value = proxy.value;
            src.dispatchEvent(new Event('input', { bubbles: true }));
            // once the filtered results render, make sure they're in view (the list may have shrunk)
            clearTimeout(initDockSearch.t);
            initDockSearch.t = setTimeout(() => {
                const results = document.querySelector('[data-dock-search] ~ section');
                if (!results) return;
                const top = results.getBoundingClientRect().top;
                if (top < 0 || top > innerHeight * 0.6) lenis ? lenis.scrollTo(results, { offset: -150, duration: 0.9 }) : results.scrollIntoView({ behavior: 'smooth' });
            }, 700);
        });
        proxy.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            const results = document.querySelector('[data-dock-search] + section, [data-dock-search] ~ section');
            if (results) (lenis ? lenis.scrollTo(results, { offset: -90 }) : results.scrollIntoView({ behavior: 'smooth' }));
        });
        dock.querySelector('[data-nav-search-filters]').addEventListener('click', () => {
            const target = document.querySelector('[data-dock-search]');
            if (!target) return;
            const focus = () => target.querySelector('input[type=search]')?.focus({ preventScroll: true });
            if (lenis) lenis.scrollTo(target, { offset: -160, duration: 1.1, onComplete: focus });
            else { target.scrollIntoView({ behavior: 'smooth', block: 'center' }); setTimeout(focus, 600); }
        });
    }
    // page → header
    if (!bar.dataset.dockBound) {
        bar.dataset.dockBound = '1';
        bar.addEventListener('input', (e) => { if (e.target.matches('input[type=search]')) proxy.value = e.target.value; });
    }

    const setDocked = (on) => {
        nav.classList.toggle('has-search', on);
        dock.setAttribute('aria-hidden', on ? 'false' : 'true');
        dock.querySelectorAll('input, button').forEach((el) => (el.tabIndex = on ? 0 : -1));
        if (on) { proxy.value = source()?.value ?? proxy.value; nav.classList.remove('is-hidden'); }
        else if (document.activeElement === proxy) source()?.focus({ preventScroll: true });
    };
    initDockSearch.trigger = ScrollTrigger.create({
        trigger: bar, start: 'bottom 72px', end: 'max',
        onToggle: (st) => setDocked(st.isActive),
    });
}

/* Article reading progress ([data-read-progress]) */
function initReadProgress() {
    const bar = document.querySelector('[data-read-progress]:not([data-bound])');
    const body = document.querySelector('.article-body');
    if (!bar || !body) return;
    bar.setAttribute('data-bound', '');
    gsap.to(bar, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: body, start: 'top 30%', end: 'bottom 70%', scrub: 0.3 } });
}

/* Slow zoom-out on photos as they scroll through ([data-img-zoom]) */
export function initImageZoom() {
    if (reduce()) return;
    document.querySelectorAll('[data-img-zoom]:not([data-zoomed])').forEach((img) => {
        img.setAttribute('data-zoomed', '');
        gsap.fromTo(img, { scale: 1.2 }, { scale: 1, ease: 'none', scrollTrigger: { trigger: img.parentElement, start: 'top bottom', end: 'bottom top', scrub: 1 } });
    });
}
