import { gsap, ScrollTrigger, reduce, fine, EASE, stages, initImageZoom } from './motion.js';

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

/* Destination list + globe labels drive the 3D globe and the photo card */
function initDestinations() {
    const rows = document.querySelectorAll('[data-dest]');
    const cards = document.querySelectorAll('[data-dest-card]');
    const globeEl = document.getElementById('hero-globe');
    if (!rows.length || !globeEl || globeEl.dataset.destBound) return;
    globeEl.dataset.destBound = '1';
    let auto = true, idx = 0, timer = null, current = null;

    const show = (key, fromUser) => {
        if (fromUser) { auto = false; clearInterval(timer); }
        if (key === current) return;
        current = key;
        rows.forEach((r) => r.setAttribute('aria-pressed', r.dataset.dest === key ? 'true' : 'false'));
        cards.forEach((card) => {
            const on = card.dataset.destCard === key;
            if (!on) { card.hidden = true; return; }
            card.hidden = false;
            if (reduce()) return;
            gsap.fromTo(card, { y: 18, opacity: 0, scale: 0.97 }, { y: 0, opacity: 1, scale: 1, duration: 0.9, ease: EASE });
            gsap.fromTo(card.querySelector('.dest-card-img'), { scale: 1.25 }, { scale: 1, duration: 1.6, ease: 'power3.out' });
        });
        stages['hero-globe']?.focus(key);
    };
    rows.forEach((r, i) => r.addEventListener('click', () => { idx = i; show(r.dataset.dest, true); }));
    globeEl.addEventListener('globe:pick', (e) => show(e.detail, true));

    const startTour = () => {
        if (reduce() || timer || !auto) return;
        show(rows[idx].dataset.dest, false);
        timer = setInterval(() => {
            if (!auto) return;
            idx = (idx + 1) % rows.length;
            show(rows[idx].dataset.dest, false);
        }, 4500);
    };
    const ready = new Promise((res) => globeEl.addEventListener('three:ready', res, { once: true }));
    // tour only while the section is on screen
    ScrollTrigger.create({
        trigger: globeEl.closest('section'), start: 'top 60%', end: 'bottom 30%',
        onToggle: (st) => { if (st.isActive) ready.then(startTour); else { clearInterval(timer); timer = null; } },
    });
}

/* Hero collage: staggered clip reveal, idle floating, depth parallax on pointer */
function initCollage() {
    const wrap = document.querySelector('[data-collage]');
    if (!wrap || wrap.dataset.bound || reduce()) return;
    wrap.dataset.bound = '1';
    const items = wrap.querySelectorAll('.collage-item');
    const badges = wrap.querySelectorAll('.collage-badge');

    gsap.fromTo(items, { clipPath: 'inset(100% 0% 0% 0% round 28px)' }, { clipPath: 'inset(0% 0% 0% 0% round 28px)', duration: 1.6, ease: 'expo.out', stagger: 0.12, delay: 0.3 });
    gsap.fromTo(wrap.querySelectorAll('.collage-item img'), { scale: 1.35 }, { scale: 1.08, duration: 2.2, ease: 'expo.out', stagger: 0.12, delay: 0.3 });
    gsap.from(badges, { opacity: 0, scale: 0.8, duration: 1.2, ease: 'back.out(1.6)', stagger: 0.15, delay: 1.1 });

    // gentle continuous float: each piece on its own rhythm (yPercent, so it never fights the scroll y)
    [...items, ...badges].forEach((el, i) => {
        gsap.to(el, { yPercent: i % 2 ? 2.5 : -2.5, duration: 3.2 + i * 0.45, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: 1.8 + i * 0.2 });
    });

    // scroll: pieces drift apart at different speeds
    [...items, ...badges].forEach((el) => {
        const d = Number(el.dataset.depth || 1);
        gsap.to(el, { y: -70 * d, ease: 'none', scrollTrigger: { trigger: wrap, start: 'top top', end: 'bottom top', scrub: 1.2 } });
    });

    if (!fine()) return;
    const movers = [...items, ...badges].map((el) => ({
        d: Number(el.dataset.depth || 1),
        x: gsap.quickTo(el, 'x', { duration: 1.4, ease: 'power3.out' }),
        r: gsap.quickTo(el, 'rotation', { duration: 1.6, ease: 'power3.out' }),
    }));
    const hero = wrap.closest('section');
    hero.addEventListener('pointermove', (e) => {
        const r = hero.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width - 0.5;
        movers.forEach((m) => { m.x(px * 34 * m.d); m.r(px * 2 * (m.d > 1.3 ? -1 : 1)); });
    });
    hero.addEventListener('pointerleave', () => movers.forEach((m) => { m.x(0); m.r(0); }));
}

/* Gallery rows glide in opposite directions as you scroll */
function initGallery() {
    const section = document.querySelector('[data-gallery]');
    if (!section || section.dataset.bound || reduce()) return;
    section.dataset.bound = '1';
    section.querySelectorAll('[data-gallery-row]').forEach((row) => {
        const dir = Number(row.dataset.galleryRow);
        gsap.fromTo(row, { x: () => (dir < 0 ? 0 : -row.scrollWidth * 0.25) }, {
            x: () => (dir < 0 ? -row.scrollWidth * 0.25 : 0), ease: 'none',
            scrollTrigger: { trigger: section, start: 'top bottom', end: 'bottom top', scrub: 1.4, invalidateOnRefresh: true },
        });
    });
    gsap.from(section.querySelectorAll('.gallery-item'), {
        scale: 0.86, opacity: 0, duration: 1.4, ease: 'expo.out', stagger: { each: 0.05, from: 'center' },
        scrollTrigger: { trigger: section, start: 'top 75%' },
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
                trigger: section, start: 'top top', end: () => '+=' + dist(), pin: true, scrub: 1.2, invalidateOnRefresh: true,
                onUpdate: (st) => bar && gsap.set(bar, { scaleX: st.progress }),
            },
        });
        // cards lift as they travel into view
        track.querySelectorAll('.faculty-card').forEach((card) => {
            gsap.fromTo(card, { rotateY: -18, opacity: 0.35, transformPerspective: 900 }, {
                rotateY: 0, opacity: 1, ease: 'none',
                scrollTrigger: { trigger: card, containerAnimation: tween, start: 'left 100%', end: 'left 60%', scrub: 1 },
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
        trigger: wrap, start: 'top 70%', end: 'bottom 55%', scrub: 1,
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
        gsap.to(hero.querySelector('[data-hero-copy]'), { yPercent: -14, opacity: 0.25, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: 1.2 } });
    }
    const cta = document.querySelector('[data-cta-zoom]');
    if (cta && !cta.dataset.bound) {
        cta.dataset.bound = '1';
        gsap.fromTo(cta, { clipPath: 'inset(8% 6% 8% 6% round 40px)' }, { clipPath: 'inset(0% 0% 0% 0% round 0px)', ease: 'none', scrollTrigger: { trigger: cta, start: 'top 90%', end: 'top 20%', scrub: 1.2 } });
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
    initCollage();
    initGallery();
    initImageZoom();
    initHScroll();
    initJourney();
    initMarquees();
    initHomeScenes();
}

export { initMarquees };
