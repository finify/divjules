import { gsap, ScrollTrigger, reduce, EASE } from './motion.js';

/* Horizontal rails: prev/next buttons + progress bar ([data-scroller="name"]) */
function initScrollers() {
    document.querySelectorAll('[data-scroller]:not([data-bound])').forEach((rail) => {
        rail.setAttribute('data-bound', '');
        const name = rail.dataset.scroller;
        const bar = document.querySelector(`[data-scroller-bar="${name}"]`);
        const step = () => (rail.querySelector(':scope > *')?.getBoundingClientRect().width || 300) + 16;
        document.querySelector(`[data-scroller-prev="${name}"]`)?.addEventListener('click', () => rail.scrollBy({ left: -step(), behavior: 'smooth' }));
        document.querySelector(`[data-scroller-next="${name}"]`)?.addEventListener('click', () => rail.scrollBy({ left: step(), behavior: 'smooth' }));
        const update = () => {
            const max = rail.scrollWidth - rail.clientWidth;
            if (bar) bar.style.transform = `scaleX(${max > 0 ? Math.max(0.08, rail.scrollLeft / max) : 1})`;
        };
        rail.addEventListener('scroll', update, { passive: true });
        update();
        if (!reduce()) {
            gsap.from(rail.children, { x: 80, opacity: 0, duration: 1.2, ease: EASE, stagger: 0.08, scrollTrigger: { trigger: rail, start: 'top 85%' } });
        }
    });
}

/* Review carousel: crossfade, autoplay with per-dot progress, swipe, keyboard */
function initQuotes() {
    document.querySelectorAll('[data-quotes]:not([data-bound])').forEach((root) => {
        root.setAttribute('data-bound', '');
        const slides = [...root.querySelectorAll('[data-quote]')];
        const dots = [...root.querySelectorAll('[data-quote-dot]')];
        if (slides.length < 2) return;
        const DURATION = 7;
        let index = 0, progress = null, paused = false;

        const fill = (i, p) => dots[i]?.querySelector('span')?.style.setProperty('--p', p);
        const go = (next, dir = 1) => {
            next = (next + slides.length) % slides.length;
            if (next === index) return;
            const from = slides[index], to = slides[next];
            dots.forEach((_, i) => fill(i, i < next ? 1 : 0));
            if (reduce()) { from.hidden = true; to.hidden = false; }
            else {
                gsap.to(from, { opacity: 0, x: -40 * dir, duration: 0.35, ease: 'power2.in', onComplete: () => { from.hidden = true; gsap.set(from, { clearProps: 'all' }); } });
                to.hidden = false;
                gsap.fromTo(to, { opacity: 0, x: 40 * dir }, { opacity: 1, x: 0, duration: 0.8, ease: EASE, delay: 0.3 });
            }
            index = next;
            start();
        };
        const start = () => {
            progress?.kill();
            if (reduce()) return;
            const o = { p: 0 };
            progress = gsap.to(o, { p: 1, duration: DURATION, ease: 'none', onUpdate: () => fill(index, o.p), onComplete: () => go(index + 1) });
            if (paused) progress.pause();
        };

        root.querySelector('[data-quote-prev]')?.addEventListener('click', () => go(index - 1, -1));
        root.querySelector('[data-quote-next]')?.addEventListener('click', () => go(index + 1, 1));
        dots.forEach((d, i) => d.addEventListener('click', () => go(i, i > index ? 1 : -1)));
        root.addEventListener('mouseenter', () => { paused = true; progress?.pause(); });
        root.addEventListener('mouseleave', () => { paused = false; progress?.resume(); });

        let sx = null;
        root.addEventListener('pointerdown', (e) => { sx = e.clientX; });
        root.addEventListener('pointerup', (e) => {
            if (sx === null) return;
            const dx = e.clientX - sx; sx = null;
            if (Math.abs(dx) > 50) go(index + (dx < 0 ? 1 : -1), dx < 0 ? 1 : -1);
        });

        // only run the clock while the carousel is on screen
        ScrollTrigger.create({ trigger: root, start: 'top bottom', end: 'bottom top', onToggle: (st) => (st.isActive ? (progress ? progress.resume() : start()) : progress?.pause()) });
    });
}

/* Paragraphs whose words light up as you scroll ([data-text-fill]) */
function initTextFill() {
    if (reduce()) return;
    document.querySelectorAll('[data-text-fill]:not([data-bound])').forEach((el) => {
        el.setAttribute('data-bound', '');
        const words = el.textContent.trim().split(/\s+/);
        el.innerHTML = words.map((w) => `<span class="fill-word">${w.replace(/</g, '&lt;')}</span>`).join(' ');
        gsap.fromTo(el.querySelectorAll('.fill-word'), { opacity: 0.18 }, {
            opacity: 1, ease: 'none', stagger: 0.1,
            scrollTrigger: { trigger: el, start: 'top 80%', end: 'bottom 45%', scrub: 1 },
        });
    });
}

/* Sticky stacked cards that shrink back as the next one arrives ([data-stack] > .stack-card) */
function initStack() {
    if (reduce()) return;
    document.querySelectorAll('[data-stack]:not([data-bound])').forEach((wrap) => {
        wrap.setAttribute('data-bound', '');
        const cards = [...wrap.querySelectorAll('.stack-card')];
        cards.forEach((card, i) => {
            card.style.zIndex = i + 1;
            if (i === cards.length - 1) return;
            gsap.to(card, {
                scale: 0.92 + i * 0.012, filter: 'brightness(0.9)', ease: 'none',
                scrollTrigger: { trigger: cards[i + 1], start: 'top bottom', end: 'top 25%', scrub: 1 },
            });
        });
    });
}

/* Images that unmask as they enter ([data-clip-reveal]) */
function initClipReveal() {
    if (reduce()) return;
    document.querySelectorAll('[data-clip-reveal]:not([data-bound])').forEach((el) => {
        el.setAttribute('data-bound', '');
        const from = el.dataset.clipReveal === 'left' ? 'inset(0% 100% 0% 0% round 28px)' : 'inset(100% 0% 0% 0% round 28px)';
        gsap.fromTo(el, { clipPath: from }, { clipPath: 'inset(0% 0% 0% 0% round 28px)', duration: 1.6, ease: 'expo.out', scrollTrigger: { trigger: el, start: 'top 85%' } });
        const img = el.querySelector('img');
        if (img) gsap.fromTo(img, { scale: 1.3 }, { scale: 1, duration: 2, ease: 'expo.out', scrollTrigger: { trigger: el, start: 'top 85%' } });
    });
}

export function initInteractions() {
    initScrollers();
    initQuotes();
    initTextFill();
    initStack();
    initClipReveal();
}
