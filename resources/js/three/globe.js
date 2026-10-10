import * as THREE from 'three';
import { makeCap, makeBook, palette } from './objects.js';

// lat/lon of the study destinations shown in the hero (origin = Lagos)
export const DESTINATIONS = {
    uk: { lat: 51.5, lon: -0.12 },
    canada: { lat: 43.65, lon: -79.38 },
    usa: { lat: 40.71, lon: -74.0 },
    australia: { lat: -33.87, lon: 151.2 },
    germany: { lat: 52.52, lon: 13.4 },
    ireland: { lat: 53.35, lon: -6.26 },
    dubai: { lat: 25.2, lon: 55.27 },
};
const ORIGIN = { lat: 6.52, lon: 3.38 };
const R = 1.6;

function toVec(lat, lon, r = R) {
    const phi = (90 - lat) * (Math.PI / 180);
    const theta = (lon + 180) * (Math.PI / 180);
    return new THREE.Vector3(-r * Math.sin(phi) * Math.cos(theta), r * Math.cos(phi), r * Math.sin(phi) * Math.sin(theta));
}

function dotTexture() {
    const c = document.createElement('canvas');
    c.width = c.height = 64;
    const g = c.getContext('2d');
    const grd = g.createRadialGradient(32, 32, 0, 32, 32, 32);
    grd.addColorStop(0, 'rgba(255,255,255,1)');
    grd.addColorStop(0.35, 'rgba(255,255,255,.9)');
    grd.addColorStop(1, 'rgba(255,255,255,0)');
    g.fillStyle = grd;
    g.fillRect(0, 0, 64, 64);
    return new THREE.CanvasTexture(c);
}

export function mountGlobe(el) {
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    el.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0.25, 6.2);

    const world = new THREE.Group();
    scene.add(world);
    const globe = new THREE.Group();
    world.add(globe);
    globe.rotation.z = 0.18;

    scene.add(new THREE.AmbientLight(0xffffff, 0.75));
    const key = new THREE.DirectionalLight(0xffffff, 1.4);
    key.position.set(3, 4, 5);
    scene.add(key);
    const rim = new THREE.PointLight(0x38bdf8, 18, 12);
    rim.position.set(-3, 1, -2);
    scene.add(rim);

    // Core sphere
    const coreMat = new THREE.MeshStandardMaterial({ color: palette().core, roughness: 0.6, metalness: 0.15, transparent: true, opacity: 0.92 });
    const core = new THREE.Mesh(new THREE.SphereGeometry(R * 0.985, 64, 64), coreMat);
    globe.add(core);

    // Fibonacci dot shell — the "map" of the world
    const N = 2400;
    const pos = new Float32Array(N * 3);
    for (let i = 0; i < N; i++) {
        const y = 1 - (i / (N - 1)) * 2;
        const r = Math.sqrt(1 - y * y);
        const t = Math.PI * (3 - Math.sqrt(5)) * i;
        pos.set([Math.cos(t) * r * R, y * R, Math.sin(t) * r * R], i * 3);
    }
    const dotGeo = new THREE.BufferGeometry();
    dotGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    const dotMat = new THREE.PointsMaterial({ size: 0.035, map: dotTexture(), transparent: true, depthWrite: false, color: palette().dots, opacity: 0.85 });
    globe.add(new THREE.Points(dotGeo, dotMat));

    // Latitude rings
    const ringMat = new THREE.LineBasicMaterial({ color: palette().ring, transparent: true, opacity: 0.25 });
    [-50, -25, 0, 25, 50].forEach((lat) => {
        const pts = [];
        for (let i = 0; i <= 96; i++) pts.push(toVec(lat, (i / 96) * 360 - 180, R * 1.002));
        globe.add(new THREE.Line(new THREE.BufferGeometry().setFromPoints(pts), ringMat));
    });

    // Atmosphere halo
    const halo = new THREE.Mesh(
        new THREE.SphereGeometry(R * 1.12, 48, 48),
        new THREE.ShaderMaterial({
            transparent: true, side: THREE.BackSide, depthWrite: false,
            uniforms: { c: { value: new THREE.Color(0x38bdf8) } },
            vertexShader: 'varying vec3 vN; void main(){ vN = normalize(normalMatrix*normal); gl_Position = projectionMatrix*modelViewMatrix*vec4(position,1.0); }',
            fragmentShader: 'uniform vec3 c; varying vec3 vN; void main(){ float i = pow(0.66 - dot(vN, vec3(0,0,1.0)), 3.0); gl_FragColor = vec4(c, i * 0.9); }',
        })
    );
    world.add(halo);

    // Origin marker
    const pinGeo = new THREE.SphereGeometry(0.045, 16, 16);
    const originPin = new THREE.Mesh(pinGeo, new THREE.MeshBasicMaterial({ color: 0xfbbf24 }));
    originPin.position.copy(toVec(ORIGIN.lat, ORIGIN.lon, R * 1.01));
    globe.add(originPin);

    // Flight arcs + travelling "students"
    const arcs = {};
    const start = toVec(ORIGIN.lat, ORIGIN.lon);
    Object.entries(DESTINATIONS).forEach(([k, d]) => {
        const end = toVec(d.lat, d.lon);
        const mid = start.clone().add(end).multiplyScalar(0.5);
        const lift = 1 + start.distanceTo(end) * 0.32;
        mid.normalize().multiplyScalar(R * lift);
        const curve = new THREE.QuadraticBezierCurve3(start, mid, end);
        const tube = new THREE.Mesh(
            new THREE.TubeGeometry(curve, 64, 0.008, 6, false),
            new THREE.MeshBasicMaterial({ color: 0x38bdf8, transparent: true, opacity: 0.55 })
        );
        tube.geometry.setDrawRange(0, 0);
        globe.add(tube);
        const pin = new THREE.Mesh(pinGeo, new THREE.MeshBasicMaterial({ color: 0x7dd3fc }));
        pin.position.copy(toVec(d.lat, d.lon, R * 1.01));
        globe.add(pin);
        const pulse = new THREE.Mesh(new THREE.RingGeometry(0.06, 0.08, 32), new THREE.MeshBasicMaterial({ color: 0x7dd3fc, transparent: true, side: THREE.DoubleSide }));
        pulse.position.copy(pin.position);
        pulse.lookAt(pin.position.clone().multiplyScalar(2));
        globe.add(pulse);
        const traveller = new THREE.Mesh(new THREE.SphereGeometry(0.03, 12, 12), new THREE.MeshBasicMaterial({ color: 0xffffff }));
        globe.add(traveller);
        arcs[k] = { curve, tube, pin, pulse, traveller, total: tube.geometry.index.count, t: Math.random(), draw: 0 };
    });

    // Orbiting academic objects
    const cap = makeCap();
    cap.scale.setScalar(0.42);
    world.add(cap);
    const book = makeBook(0x0369a1);
    book.scale.setScalar(0.42);
    world.add(book);

    // --- interaction state
    const state = { tx: 0, ty: 0, mx: 0, my: 0, dragging: false, lastX: 0, lastY: 0, velX: 0, spin: 0, focus: null, scroll: 0, visible: true };
    let targetRotY = null;

    function focus(key) {
        state.focus = key;
        const d = DESTINATIONS[key];
        if (!d) return;
        // rotate the globe so the destination faces the camera
        const v = toVec(d.lat, d.lon).applyAxisAngle(new THREE.Vector3(0, 0, 1), globe.rotation.z);
        const angle = Math.atan2(v.x, v.z);
        const current = globe.rotation.y;
        let goal = -angle;
        goal += Math.round((current - goal) / (Math.PI * 2)) * Math.PI * 2;
        targetRotY = goal;
        Object.entries(arcs).forEach(([k, a]) => {
            a.tube.material.opacity = k === key ? 1 : 0.18;
            a.pin.scale.setScalar(k === key ? 2 : 1);
        });
    }
    function clearFocus() {
        state.focus = null;
        targetRotY = null;
        Object.values(arcs).forEach((a) => { a.tube.material.opacity = 0.55; a.pin.scale.setScalar(1); });
    }

    const canvas = renderer.domElement;
    canvas.style.cursor = 'grab';
    canvas.style.touchAction = 'pan-y';
    canvas.addEventListener('pointerdown', (e) => {
        state.dragging = true; state.lastX = e.clientX; state.lastY = e.clientY; targetRotY = null;
        canvas.style.cursor = 'grabbing';
    });
    window.addEventListener('pointerup', () => { state.dragging = false; canvas.style.cursor = 'grab'; });
    window.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        state.mx = ((e.clientX - r.left) / r.width) * 2 - 1;
        state.my = ((e.clientY - r.top) / r.height) * 2 - 1;
        if (state.dragging) {
            const dx = e.clientX - state.lastX;
            state.velX = dx * 0.006;
            globe.rotation.y += state.velX;
            globe.rotation.x = THREE.MathUtils.clamp(globe.rotation.x + (e.clientY - state.lastY) * 0.003, -0.6, 0.6);
            state.lastX = e.clientX; state.lastY = e.clientY;
        }
    });

    function resize() {
        const w = el.clientWidth, h = el.clientHeight;
        if (!w || !h) return;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.position.z = w < 640 ? 7.2 : 6.2;
        camera.updateProjectionMatrix();
    }
    new ResizeObserver(resize).observe(el);
    resize();

    new IntersectionObserver(([e]) => { state.visible = e.isIntersecting; }, { threshold: 0 }).observe(el);

    function applyTheme() {
        const p = palette();
        coreMat.color.set(p.core);
        dotMat.color.set(p.dots);
        ringMat.color.set(p.ring);
    }
    window.addEventListener('dj:theme', applyTheme);

    const clock = new THREE.Clock();
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function tick() {
        requestAnimationFrame(tick);
        if (!state.visible) return;
        const dt = Math.min(clock.getDelta(), 0.05);
        const t = clock.elapsedTime;

        if (!state.dragging) {
            if (targetRotY !== null) globe.rotation.y += (targetRotY - globe.rotation.y) * 0.06;
            else if (!reduce) globe.rotation.y += 0.0018 + state.velX;
            state.velX *= 0.94;
            globe.rotation.x += (0 - globe.rotation.x) * 0.02;
        }
        // mouse parallax on the whole world
        world.rotation.y += (state.mx * 0.18 - world.rotation.y) * 0.05;
        world.rotation.x += (state.my * 0.1 - world.rotation.x) * 0.05;
        // scroll pushes the globe back & down
        world.position.y = -state.scroll * 1.2;
        world.scale.setScalar(1 - state.scroll * 0.18);

        Object.entries(arcs).forEach(([k, a]) => {
            if (a.draw < a.total) { a.draw = Math.min(a.total, a.draw + a.total * dt * 0.9); a.tube.geometry.setDrawRange(0, Math.floor(a.draw)); }
            a.t = (a.t + dt * (state.focus === k ? 0.35 : 0.18)) % 1;
            a.traveller.position.copy(a.curve.getPoint(a.t));
            a.traveller.visible = a.draw >= a.total && (!state.focus || state.focus === k);
            const s = 1 + ((t * 0.8 + a.t) % 1) * 2.4;
            a.pulse.scale.setScalar(s);
            a.pulse.material.opacity = 1 - (s - 1) / 2.4;
        });

        cap.position.set(Math.cos(t * 0.35) * 2.05, 0.9 + Math.sin(t * 0.7) * 0.15, Math.sin(t * 0.35) * 1.4);
        cap.rotation.set(0.7 + Math.sin(t) * 0.08, t * 0.6, Math.sin(t * 0.5) * 0.12);
        book.position.set(Math.cos(t * 0.35 + Math.PI) * 2.0, -0.9 + Math.cos(t * 0.6) * 0.15, Math.sin(t * 0.35 + Math.PI) * 1.2);
        book.rotation.set(t * 0.4, t * 0.3, 0.2);

        renderer.render(scene, camera);
    }
    tick();

    return {
        focus, clearFocus,
        setScroll(p) { state.scroll = p; },
    };
}
