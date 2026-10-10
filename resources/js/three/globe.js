import * as THREE from 'three';
import { palette } from './objects.js';

// Study destinations (origin = Lagos). Labels are drawn as HTML so they stay crisp.
export const DESTINATIONS = {
    uk: { lat: 51.5, lon: -0.12, name: 'United Kingdom' },
    canada: { lat: 43.65, lon: -79.38, name: 'Canada' },
    usa: { lat: 40.71, lon: -74.0, name: 'United States' },
    australia: { lat: -33.87, lon: 151.2, name: 'Australia' },
    germany: { lat: 52.52, lon: 13.4, name: 'Germany' },
    ireland: { lat: 53.35, lon: -6.26, name: 'Ireland' },
    dubai: { lat: 25.2, lon: 55.27, name: 'Dubai' },
};
const ORIGIN = { lat: 6.52, lon: 3.38, name: 'Lagos' };
const R = 1.6;
const LAND_MAP = '/homeassets/img/site/earth-water.png'; // white = water, black = land

function toVec(lat, lon, r = R) {
    const phi = (90 - lat) * (Math.PI / 180);
    const theta = (lon + 180) * (Math.PI / 180);
    return new THREE.Vector3(-r * Math.sin(phi) * Math.cos(theta), r * Math.cos(phi), r * Math.sin(phi) * Math.sin(theta));
}

function dotTexture() {
    const c = document.createElement('canvas');
    c.width = c.height = 64;
    const g = c.getContext('2d');
    g.beginPath();
    g.arc(32, 32, 26, 0, Math.PI * 2);
    g.fillStyle = '#fff';
    g.fill();
    return new THREE.CanvasTexture(c);
}

function loadLandMask() {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => {
            const c = document.createElement('canvas');
            c.width = img.width; c.height = img.height;
            const g = c.getContext('2d', { willReadFrequently: true });
            g.drawImage(img, 0, 0);
            const { data, width, height } = g.getImageData(0, 0, c.width, c.height);
            resolve((lat, lon) => {
                const x = Math.floor(((lon + 180) / 360) * width) % width;
                const y = Math.min(height - 1, Math.floor(((90 - lat) / 180) * height));
                return data[(y * width + x) * 4] < 128;
            });
        };
        img.onerror = () => resolve(null);
        img.src = LAND_MAP;
    });
}

export function mountGlobe(el) {
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    el.appendChild(renderer.domElement);

    const labelLayer = document.createElement('div');
    labelLayer.className = 'globe-labels';
    el.appendChild(labelLayer);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(36, 1, 0.1, 100);
    camera.position.set(0, 0, 6.4);

    const world = new THREE.Group();
    scene.add(world);
    const globe = new THREE.Group();
    world.add(globe);
    globe.rotation.x = 0.35; // tilt so the northern hemisphere (most destinations) faces us

    scene.add(new THREE.AmbientLight(0xffffff, 0.9));
    const key = new THREE.DirectionalLight(0xffffff, 1.2);
    key.position.set(-3, 3, 5);
    scene.add(key);

    // Ocean sphere
    const coreMat = new THREE.MeshPhongMaterial({ color: palette().core, shininess: 18, specular: 0x1e3a8a, transparent: true, opacity: 0.96 });
    globe.add(new THREE.Mesh(new THREE.SphereGeometry(R * 0.99, 72, 72), coreMat));

    // Land: dots on a fibonacci lattice, kept only where the mask says land
    const dotMat = new THREE.PointsMaterial({ size: 0.042, map: dotTexture(), transparent: true, alphaTest: 0.4, color: palette().dots, sizeAttenuation: true });
    loadLandMask().then((isLand) => {
        const N = 26000, pts = [];
        for (let i = 0; i < N; i++) {
            const y = 1 - (i / (N - 1)) * 2;
            const lat = Math.asin(y) * (180 / Math.PI);
            const lon = ((((Math.PI * (3 - Math.sqrt(5)) * i) * 180) / Math.PI) % 360) - 180;
            if (!isLand || isLand(lat, lon)) pts.push(toVec(lat, lon, R * 1.002));
        }
        globe.add(new THREE.Points(new THREE.BufferGeometry().setFromPoints(pts), dotMat));
    });

    // Atmosphere
    const halo = new THREE.Mesh(
        new THREE.SphereGeometry(R * 1.14, 64, 64),
        new THREE.ShaderMaterial({
            transparent: true, side: THREE.BackSide, depthWrite: false, blending: THREE.AdditiveBlending,
            uniforms: { c: { value: new THREE.Color(0x38bdf8) } },
            vertexShader: 'varying vec3 vN; void main(){ vN = normalize(normalMatrix*normal); gl_Position = projectionMatrix*modelViewMatrix*vec4(position,1.0); }',
            fragmentShader: 'uniform vec3 c; varying vec3 vN; void main(){ float i = pow(0.62 - dot(vN, vec3(0,0,1.0)), 4.0); gl_FragColor = vec4(c, 1.0) * i * 1.4; }',
        })
    );
    world.add(halo);

    // Markers, arcs, travellers, labels
    const pinGeo = new THREE.SphereGeometry(0.035, 16, 16);
    const makeLabel = (text, cls) => {
        const d = document.createElement('button');
        d.type = 'button';
        d.className = 'globe-label ' + cls;
        d.innerHTML = `<span class="globe-label-dot"></span>${text}`;
        labelLayer.appendChild(d);
        return d;
    };

    const originPos = toVec(ORIGIN.lat, ORIGIN.lon, R * 1.01);
    const originPin = new THREE.Mesh(new THREE.SphereGeometry(0.05, 16, 16), new THREE.MeshBasicMaterial({ color: 0xfbbf24 }));
    originPin.position.copy(originPos);
    globe.add(originPin);
    const labels = [{ el: makeLabel(ORIGIN.name, 'is-origin'), pos: originPos, key: 'origin' }];

    const arcs = {};
    const start = toVec(ORIGIN.lat, ORIGIN.lon);
    Object.entries(DESTINATIONS).forEach(([k, d], i) => {
        const end = toVec(d.lat, d.lon);
        const mid = start.clone().add(end).multiplyScalar(0.5);
        mid.normalize().multiplyScalar(R * (1 + start.distanceTo(end) * 0.28));
        const curve = new THREE.QuadraticBezierCurve3(start, mid, end);
        const tubeMat = new THREE.MeshBasicMaterial({ color: 0x38bdf8, transparent: true, opacity: 0.7 });
        const tube = new THREE.Mesh(new THREE.TubeGeometry(curve, 96, 0.007, 6, false), tubeMat);
        tube.geometry.setDrawRange(0, 0);
        globe.add(tube);
        const pinPos = toVec(d.lat, d.lon, R * 1.01);
        const pin = new THREE.Mesh(pinGeo, new THREE.MeshBasicMaterial({ color: 0x7dd3fc }));
        pin.position.copy(pinPos);
        globe.add(pin);
        const pulse = new THREE.Mesh(new THREE.RingGeometry(0.05, 0.065, 40), new THREE.MeshBasicMaterial({ color: 0x7dd3fc, transparent: true, side: THREE.DoubleSide, depthWrite: false }));
        pulse.position.copy(pinPos);
        pulse.lookAt(pinPos.clone().multiplyScalar(2));
        globe.add(pulse);
        const traveller = new THREE.Mesh(new THREE.SphereGeometry(0.028, 12, 12), new THREE.MeshBasicMaterial({ color: 0xffffff }));
        globe.add(traveller);
        const label = makeLabel(d.name, 'is-dest');
        labels.push({ el: label, pos: pinPos, key: k });
        arcs[k] = { curve, tube, tubeMat, pin, pulse, traveller, total: tube.geometry.index.count, t: Math.random(), draw: 0, delay: 0.4 + i * 0.18, emph: 0 };
    });

    // ---- interaction: inertia drag, eased focus, pointer parallax
    const S = { dragging: false, lastX: 0, lastY: 0, vx: 0, mx: 0, my: 0, sx: 0, sy: 0, focus: null, scroll: 0, sScroll: 0, visible: true };
    let targetY = null, targetX = 0.35;

    function focus(k) {
        const d = DESTINATIONS[k];
        if (!d) return;
        S.focus = k;
        const v = toVec(d.lat, d.lon);
        let goal = -Math.atan2(v.x, v.z);
        goal += Math.round((globe.rotation.y - goal) / (Math.PI * 2)) * Math.PI * 2;
        targetY = goal;
        targetX = THREE.MathUtils.clamp(((d.lat * Math.PI) / 180) * 0.85, -0.6, 0.9);
        labels.forEach((l) => l.el.classList.toggle('is-active', l.key === k));
    }
    function clearFocus() {
        S.focus = null; targetY = null; targetX = 0.35;
        labels.forEach((l) => l.el.classList.remove('is-active'));
    }
    labels.forEach((l) => {
        if (!DESTINATIONS[l.key]) return;
        l.el.addEventListener('click', () => el.dispatchEvent(new CustomEvent('globe:pick', { detail: l.key, bubbles: true })));
    });

    const canvas = renderer.domElement;
    canvas.style.cursor = 'grab';
    canvas.style.touchAction = 'pan-y';
    canvas.addEventListener('pointerdown', (e) => {
        S.dragging = true; S.lastX = e.clientX; S.lastY = e.clientY; S.vx = 0; targetY = null;
        canvas.style.cursor = 'grabbing';
    });
    window.addEventListener('pointerup', () => { if (S.dragging) { S.dragging = false; canvas.style.cursor = 'grab'; } });
    window.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        S.mx = ((e.clientX - r.left) / r.width) * 2 - 1;
        S.my = ((e.clientY - r.top) / r.height) * 2 - 1;
        if (S.dragging) {
            S.vx = (e.clientX - S.lastX) * 0.005;
            globe.rotation.y += S.vx;
            targetX = THREE.MathUtils.clamp(targetX + (e.clientY - S.lastY) * 0.003, -0.7, 1.0);
            S.lastX = e.clientX; S.lastY = e.clientY;
        }
    });

    let W = 1, H = 1;
    function resize() {
        W = el.clientWidth; H = el.clientHeight;
        if (!W || !H) return;
        renderer.setSize(W, H, false);
        camera.aspect = W / H;
        camera.position.z = W < 640 ? 7.6 : 6.2;
        camera.updateProjectionMatrix();
    }
    new ResizeObserver(resize).observe(el);
    resize();
    new IntersectionObserver(([e]) => { S.visible = e.isIntersecting; }).observe(el);

    window.addEventListener('dj:theme', () => {
        const p = palette();
        coreMat.color.set(p.core);
        dotMat.color.set(p.dots);
    });

    const clock = new THREE.Clock();
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const tmp = new THREE.Vector3(), nrm = new THREE.Vector3(), toCam = new THREE.Vector3(), center = new THREE.Vector3();
    // frame-rate independent smoothing
    const damp = (a, b, lambda, dt) => THREE.MathUtils.lerp(a, b, 1 - Math.exp(-lambda * dt));

    function tick() {
        requestAnimationFrame(tick);
        if (!S.visible) return;
        const dt = Math.min(clock.getDelta(), 0.05);
        const t = clock.elapsedTime;

        if (!S.dragging) {
            if (targetY !== null) {
                globe.rotation.y = damp(globe.rotation.y, targetY, 2.6, dt);
            } else {
                // momentum after a drag, easing back into a slow idle spin
                S.vx = damp(S.vx, reduce ? 0 : 0.0014, 1.4, dt);
                globe.rotation.y += S.vx;
            }
        }
        globe.rotation.x = damp(globe.rotation.x, targetX, 2.6, dt);

        // smoothed pointer parallax + scroll response
        S.sx = damp(S.sx, S.mx, 2.2, dt);
        S.sy = damp(S.sy, S.my, 2.2, dt);
        S.sScroll = damp(S.sScroll, S.scroll, 4, dt);
        world.rotation.y = S.sx * 0.12;
        world.rotation.x = S.sy * 0.08;
        world.position.y = -S.sScroll * 0.5;

        Object.entries(arcs).forEach(([k, a]) => {
            if (t > a.delay && a.draw < a.total) {
                a.draw = Math.min(a.total, a.draw + a.total * dt * 0.7);
                a.tube.geometry.setDrawRange(0, Math.floor(a.draw));
            }
            const on = !S.focus || S.focus === k;
            a.emph = damp(a.emph, S.focus === k ? 1 : 0, 5, dt);
            a.tubeMat.opacity = damp(a.tubeMat.opacity, on ? 0.8 : 0.12, 4, dt);
            a.pin.scale.setScalar(1 + a.emph * 0.9);
            a.t = (a.t + dt * (0.14 + a.emph * 0.16)) % 1;
            const e = a.t < 0.5 ? 4 * a.t ** 3 : 1 - (-2 * a.t + 2) ** 3 / 2; // eased "flight"
            a.traveller.position.copy(a.curve.getPoint(e));
            a.traveller.visible = a.draw >= a.total && on;
            const s = 1 + ((t * 0.55 + a.delay) % 1) * 2.6;
            a.pulse.scale.setScalar(s);
            a.pulse.material.opacity = (1 - (s - 1) / 2.6) * (on ? 1 : 0.3);
        });

        renderer.render(scene, camera);

        // project labels; fade them out as they turn to the far side
        world.getWorldPosition(center);
        labels.forEach((l) => {
            tmp.copy(l.pos).applyMatrix4(globe.matrixWorld);
            nrm.copy(tmp).sub(center).normalize();
            toCam.copy(camera.position).sub(tmp).normalize();
            const facing = nrm.dot(toCam);
            tmp.project(camera);
            const x = (tmp.x * 0.5 + 0.5) * W, y = (-tmp.y * 0.5 + 0.5) * H;
            const vis = facing > 0.2 ? Math.min(1, (facing - 0.2) * 4) : 0;
            l.el.style.transform = `translate3d(${x.toFixed(1)}px, ${y.toFixed(1)}px, 0)`;
            l.el.style.opacity = vis.toFixed(2);
            l.el.style.pointerEvents = vis > 0.5 ? 'auto' : 'none';
        });
    }
    tick();

    return { focus, clearFocus, setScroll(p) { S.scroll = p; } };
}
