import * as THREE from 'three';
import { makeCap, makeBook, makePencil, makeAtom, makePlane, makeGlobeMini } from './objects.js';

const FACTORIES = {
    cap: makeCap,
    book: () => makeBook(0x0369a1),
    book2: () => makeBook(0xfbbf24),
    pencil: makePencil,
    atom: makeAtom,
    plane: makePlane,
    globe: makeGlobeMini,
};

// Layout presets: where each object floats inside the stage (x, y in -1..1 of the visible frame)
const PRESETS = {
    hero: [
        ['cap', 0.78, 0.3, 0.9], ['book', 0.86, -0.5, 0.75], ['atom', -0.85, 0.35, 0.8],
        ['pencil', -0.72, -0.55, 0.55], ['plane', -0.35, -0.75, 0.4], ['globe', 0.6, -0.72, 0.45],
    ],
    cta: [
        ['cap', -0.78, 0.4, 1], ['book2', 0.8, 0.45, 0.8], ['plane', 0.65, -0.55, 0.6], ['atom', -0.7, -0.5, 0.75],
    ],
    collage: [['cap', -0.88, 0.82, 0.7], ['book2', 0.92, -0.88, 0.6], ['atom', 0.1, -0.95, 0.45], ['plane', -0.92, -0.35, 0.45]],
    strip: [['cap', 0.42, 0.05, 1.1], ['atom', 0.72, 0.3, 0.7], ['pencil', 0.12, -0.35, 0.6]],
    side: [['cap', 0.45, 0.35, 1.1], ['book', 0.78, -0.35, 0.8], ['atom', -0.55, 0.6, 0.6], ['pencil', 0.2, -0.6, 0.5], ['globe', 0.85, 0.6, 0.45]],
};

/**
 * Mount a scene of floating academic objects into `el`.
 * Objects bob, react to the pointer (parallax + push away) and to scroll.
 */
export function mountFloaters(el, preset = 'hero') {
    const items = PRESETS[preset] || PRESETS.hero;
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    el.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(35, 1, 0.1, 100);
    camera.position.z = 10;
    scene.add(new THREE.AmbientLight(0xffffff, 0.9));
    const key = new THREE.DirectionalLight(0xffffff, 1.6);
    key.position.set(4, 5, 6);
    scene.add(key);
    const fill = new THREE.PointLight(0x38bdf8, 25, 20);
    fill.position.set(-5, -2, 4);
    scene.add(fill);

    const objs = items.map(([type, x, y, s], i) => {
        const o = FACTORIES[type]();
        o.userData.base = { x, y, s, seed: i * 1.7 + Math.random() };
        o.userData.push = new THREE.Vector2();
        o.rotation.set(Math.random() * 0.6, Math.random() * Math.PI, Math.random() * 0.4);
        scene.add(o);
        return o;
    });

    const pointer = { x: 0, y: 0, active: false };
    const sp = { x: 0, y: 0, s: 0 }; // smoothed pointer + scroll
    const scrollState = { p: 0 };
    let visible = true, w = 1, h = 1, halfW = 1, halfH = 1;

    function resize() {
        w = el.clientWidth; h = el.clientHeight;
        if (!w || !h) return;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        halfH = Math.tan(THREE.MathUtils.degToRad(camera.fov / 2)) * camera.position.z;
        halfW = halfH * camera.aspect;
        const mobile = w < 640;
        objs.forEach((o) => {
            const { s } = o.userData.base;
            o.scale.setScalar(s * (mobile ? 0.55 : 1) * Math.min(1.2, halfH / 3.2));
        });
    }
    new ResizeObserver(resize).observe(el);
    resize();
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }).observe(el);

    const host = el.parentElement;
    host.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        pointer.x = ((e.clientX - r.left) / r.width) * 2 - 1;
        pointer.y = -(((e.clientY - r.top) / r.height) * 2 - 1);
        pointer.active = true;
    });
    host.addEventListener('pointerleave', () => { pointer.active = false; });

    // click / tap on an object gives it a spin
    const ray = new THREE.Raycaster();
    host.addEventListener('click', (e) => {
        const r = el.getBoundingClientRect();
        ray.setFromCamera(new THREE.Vector2(((e.clientX - r.left) / r.width) * 2 - 1, -(((e.clientY - r.top) / r.height) * 2 - 1)), camera);
        const hit = ray.intersectObjects(objs, true)[0];
        if (!hit) return;
        let o = hit.object;
        while (o.parent && !objs.includes(o)) o = o.parent;
        o.userData.spin = 0.35;
    });

    const clock = new THREE.Clock();
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const tmp = new THREE.Vector3();

    (function tick() {
        requestAnimationFrame(tick);
        if (!visible) return;
        const t = reduce ? 0 : clock.getElapsedTime();
        sp.x += ((pointer.active ? pointer.x : 0) - sp.x) * 0.05;
        sp.y += ((pointer.active ? pointer.y : 0) - sp.y) * 0.05;
        sp.s += (scrollState.p - sp.s) * 0.08;
        objs.forEach((o, i) => {
            const b = o.userData.base;
            const bx = b.x * halfW * 0.92, by = b.y * halfH * 0.85 - sp.s * (1.5 + i * 0.4);
            // push away from the pointer
            if (pointer.active) {
                tmp.set(pointer.x * halfW - bx, pointer.y * halfH - by, 0);
                const d = tmp.length();
                const f = Math.max(0, 1 - d / 2.2);
                o.userData.push.x += (-tmp.x / (d || 1) * f * 0.9 - o.userData.push.x) * 0.05;
                o.userData.push.y += (-tmp.y / (d || 1) * f * 0.9 - o.userData.push.y) * 0.05;
            } else {
                o.userData.push.multiplyScalar(0.96);
            }
            o.position.set(
                bx + Math.sin(t * 0.6 + b.seed) * 0.15 + o.userData.push.x + sp.x * 0.25 * (i % 2 ? 1 : -1),
                by + Math.sin(t * 0.9 + b.seed) * 0.22 + o.userData.push.y + sp.y * 0.2,
                Math.sin(t * 0.4 + b.seed) * 0.6
            );
            const spin = o.userData.spin || 0;
            o.rotation.y += 0.004 + spin;
            o.rotation.x += Math.sin(t * 0.5 + b.seed) * 0.002;
            o.userData.spin = spin * 0.95;
            if (o.userData.update) o.userData.update(t);
        });
        renderer.render(scene, camera);
    })();

    return { setScroll(p) { scrollState.p = p; } };
}
