import { gsap, ScrollTrigger, reduce, EASE, stages } from './motion.js';

/* Rotating word in the hero headline */
function initWordSwap() {
    const wrap = document.querySelector('[data-word-swap]');
    if (!wrap || wrap.dataset.bound) return;
    wrap.dataset.bound = '1';
    const words = [...wrap.children];
    words.forEach((w, i) => gsap.set(w, { yPercent: i === 0 ? 0 : 110, opacity: i === 0 ? 1 : 0, position: i === 0 ? 'relative' : 'absolute' }));
    if (reduce() || words.length < 2) return;
    gsap.set(wrap, { width: words[0].offsetWidth });
    let i = 0;
    setInterval(() => {
        const cur = words[i];
        i = (i + 1) % words.length;
        const next = words[i];
        gsap.to(cur, { yPercent: -110, opacity: 0, duration: 0.7, ease: 'expo.inOut' });
        gsap.fromTo(next, { yPercent: 110, opacity: 0 }, { yPercent: 0, opacity: 1, duration: 0.7, ease: 'expo.inOut' });
        // the box follows the incoming word so the line never leaves a gap
        gsap.to(wrap, { width: next.offsetWidth, duration: 0.7, ease: 'expo.inOut' });
    }, 2600);
}

/* Destination chips drive the 3D globe + info card */
function initDestinations() {
    const chips = document.querySelectorAll('[data-dest]');
    const cards = document.querySelectorAll('[data-dest-card]');
    if (!chips.length) return;
    const globeEl = document.getElementById('hero-globe');
    let auto = true, idx = -1, timer;

    const show = (key, fromUser) => {
        chips.forEach((c) => c.setAttribute('aria-pressed', c.dataset.dest === key ? 'true' : 'false'));
        cards.forEach((card) => {
            const on = card.dataset.destCard === key;
            card.hidden = !on;
            if (on && !reduce()) gsap.fromTo(card, { y: 10, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5, ease: EASE });
        });
        stages['hero-globe']?.focus(key);
        if (fromUser) { auto = false; clearInterval(timer); }
    };
    chips.forEach((c) => {
        c.addEventListener('click', () => {
            if (c.getAttribute('aria-pressed') === 'true') {
                c.setAttribute('aria-pressed', 'false');
                cards.forEach((card) => (card.hidden = card.dataset.destCard !== 'default'));
                stages['hero-globe']?.clearFocus();
                return;
            }
            show(c.dataset.dest, true);
        });
        c.addEventListener('mouseenter', () => { if (!auto) stages['hero-globe']?.focus(c.dataset.dest); });
    });
    // tour the destinations once the globe is ready, until the visitor takes over
    globeEl?.addEventListener('three:ready', () => {
        if (reduce()) return;
        timer = setInterval(() => {
            if (!auto) return;
            idx = (idx + 1) % chips.length;
            show(chips[idx].dataset.dest, false);
        }, 4200);
    });
}

/* Pinned horizontal scroll for the faculties rail (desktop); native swipe on touch */
function initHScroll() {
    const section = document.querySelector('[data-hscroll]');
    if (!section || section.dataset.bound) return;
    section.dataset.bound = '1';
    const track = section.querySelector('.h-scroll-track');
    const bar = section.querySelector('[data-hscroll-bar]');
    const mm = gsap.matchMedia();
    mm.add('(min-width: 1024px) and (prefers-reduced-motion: no-preference)', () => {
        const dist = () => track.scrollWidth - track.parentElement.clientWidth;
        const tween = gsap.to(track, {
            x: () => -dist(), ease: 'none',
            scrollTrigger: {
                trigger: section, start: 'top top', end: () => '+=' + dist(), pin: true, scrub: 0.6, invalidateOnRefresh: true,
                onUpdate: (st) => bar && gsap.set(bar, { scaleX: st.progress }),
            },
        });
        // cards lift as they travel into view
        track.querySelectorAll('.faculty-card').forEach((card) => {
            gsap.fromTo(card, { rotateY: -18, opacity: 0.35, transformPerspective: 900 }, {
                rotateY: 0, opacity: 1, ease: 'none',
                scrollTrigger: { trigger: card, containerAnimation: tween, start: 'left 100%', end: 'left 60%', scrub: true },
            });
        });
        return () => gsap.set(track, { clearProps: 'x' });
    });
}

/* Journey: line draws with scroll and steps light up */
function initJourney() {
    const wrap = document.querySelector('[data-journey]');
    if (!wrap || wrap.dataset.bound) return;
    wrap.dataset.bound = '1';
    const fill = wrap.querySelector('[data-journey-fill]');
    const steps = wrap.querySelectorAll('.journey-step');
    const vertical = () => innerWidth < 1024;
    ScrollTrigger.create({
        trigger: wrap, start: 'top 70%', end: 'bottom 55%', scrub: true,
        onUpdate: (st) => {
            const p = st.progress;
            if (fill) fill.style.transform = vertical() ? `scaleY(${p})` : `scaleX(${p})`;
            steps.forEach((s, i) => s.setAttribute('data-active', p >= i / steps.length + 0.02 || (i === 0 && p > 0) ? 'true' : 'false'));
        },
    });
}

/* Velocity-reactive marquee (destinations ticker + schools) with drag on touch */
function initMarquees() {
    document.querySelectorAll('[data-marquee]:not([data-bound])').forEach((wrap) => {
        wrap.setAttribute('data-bound', '');
        const track = wrap.querySelector('.marquee');
        if (!track || reduce()) return;
        const dir = wrap.dataset.marquee === 'right' ? 1 : -1;
        const base = Number(wrap.dataset.marqueeSpeed || 40);
        let x = 0, boost = 0, paused = false, dragging = false, lastX = 0;
        const half = () => track.scrollWidth / 2;
        ScrollTrigger.create({ trigger: wrap, start: 'top bottom', end: 'bottom top', onUpdate: (st) => { boost = Math.min(Math.abs(st.getVelocity()) / 8, 400); } });
        wrap.addEventListener('mouseenter', () => (paused = true));
        wrap.addEventListener('mouseleave', () => (paused = false));
        wrap.addEventListener('pointerdown', (e) => { dragging = true; lastX = e.clientX; });
        window.addEventListener('pointerup', () => (dragging = false));
        wrap.addEventListener('pointermove', (e) => { if (dragging) { x += e.clientX - lastX; lastX = e.clientX; } });
        wrap.querySelectorAll('[data-marquee-nudge]').forEach((b) => b.addEventListener('click', () => {
            const amt = Number(b.dataset.marqueeNudge) * 260;
            const o = { v: 0, last: 0 };
            gsap.to(o, { v: amt, duration: 0.8, ease: 'power3.out', onUpdate: () => { x += o.v - o.last; o.last = o.v; } });
        }));
        gsap.ticker.add((t, dt) => {
            const speed = paused || dragging ? 0 : (base + boost) * dir;
            boost *= 0.92;
            x += speed * (dt / 1000);
            const h = half();
            if (h > 0) { if (x <= -h) x += h; if (x > 0) x -= h; }
            track.style.transform = `translate3d(${x}px,0,0)`;
        });
    });
}

/* Hero intro + section-specific scroll moments */
function initHomeScenes() {
    if (reduce()) return;
    const hero = document.querySelector('[data-home-hero]');
    if (hero && !hero.dataset.bound) {
        hero.dataset.bound = '1';
        gsap.from(hero.querySelectorAll('[data-hero-in]'), { y: 24, opacity: 0, duration: 1, ease: EASE, stagger: 0.08, delay: 0.5 });
        gsap.to(hero.querySelector('[data-hero-copy]'), { yPercent: -18, opacity: 0.2, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
    }
    const cta = document.querySelector('[data-cta-zoom]');
    if (cta && !cta.dataset.bound) {
        cta.dataset.bound = '1';
        gsap.fromTo(cta, { clipPath: 'inset(8% 6% 8% 6% round 40px)' }, { clipPath: 'inset(0% 0% 0% 0% round 0px)', ease: 'none', scrollTrigger: { trigger: cta, start: 'top 90%', end: 'top 20%', scrub: true } });
    }
    const why = document.querySelector('[data-why-stack]');
    if (why && !why.dataset.bound) {
        why.dataset.bound = '1';
        gsap.from(why.querySelectorAll('.card'), { y: 80, rotate: (i) => (i % 2 ? 2 : -2), opacity: 0, duration: 1.1, ease: EASE, stagger: 0.12, scrollTrigger: { trigger: why, start: 'top 80%' } });
    }
}

export function initHome() {
    if (!document.querySelector('[data-home-hero]')) return;
    initWordSwap();
    initDestinations();
    initHScroll();
    initJourney();
    initMarquees();
    initHomeScenes();
}

export { initMarquees };
