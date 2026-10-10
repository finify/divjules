import * as THREE from 'three';

// Theme-aware colours for the 3D scenes (brand navy + sky stay constant)
export function palette() {
    const dark = document.documentElement.classList.contains('dark');
    return dark
        ? { core: 0x14164a, dots: 0x7dd3fc, ring: 0x38bdf8 }
        : { core: 0x1a1a4e, dots: 0xbae6fd, ring: 0x7dd3fc };
}

const mat = (color, extra = {}) => new THREE.MeshStandardMaterial({ color, roughness: 0.45, metalness: 0.1, ...extra });

// Graduation cap: square board + skull cap + button + tassel
export function makeCap() {
    const g = new THREE.Group();
    const navy = mat(0x22225e, { roughness: 0.5, emissive: 0x0b1a40, emissiveIntensity: 0.6 });
    const board = new THREE.Mesh(new THREE.BoxGeometry(1.6, 0.06, 1.6), navy);
    board.rotation.y = Math.PI / 4;
    g.add(board);
    const skull = new THREE.Mesh(new THREE.CylinderGeometry(0.55, 0.62, 0.45, 32, 1, true), navy);
    skull.position.y = -0.25;
    g.add(skull);
    const gold = mat(0xfbbf24, { metalness: 0.5, roughness: 0.3 });
    const button = new THREE.Mesh(new THREE.SphereGeometry(0.07, 16, 16), gold);
    button.position.y = 0.06;
    g.add(button);
    const cord = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.015, 0.8, 8), gold);
    cord.rotation.z = Math.PI / 2;
    cord.position.set(0.4, 0.05, 0);
    g.add(cord);
    const tassel = new THREE.Mesh(new THREE.ConeGeometry(0.07, 0.38, 12), gold);
    tassel.position.set(0.8, -0.18, 0);
    g.add(tassel);
    return g;
}

// Closed book with cover, page block and spine band
export function makeBook(color = 0x0369a1) {
    const g = new THREE.Group();
    const cover = mat(color);
    const pages = mat(0xf8fafc, { roughness: 0.9 });
    const w = 1.1, h = 1.5, d = 0.32;
    const top = new THREE.Mesh(new THREE.BoxGeometry(w, 0.04, h), cover);
    top.position.y = d / 2;
    const bottom = top.clone();
    bottom.position.y = -d / 2;
    const spine = new THREE.Mesh(new THREE.BoxGeometry(0.04, d + 0.04, h), cover);
    spine.position.x = -w / 2;
    const block = new THREE.Mesh(new THREE.BoxGeometry(w - 0.06, d - 0.04, h - 0.08), pages);
    block.position.x = 0.02;
    const band = new THREE.Mesh(new THREE.BoxGeometry(0.06, d + 0.06, 0.12), mat(0xfbbf24, { metalness: 0.4 }));
    band.position.set(-w / 2, 0, h * 0.3);
    g.add(top, bottom, spine, block, band);
    return g;
}

export function makePencil() {
    const g = new THREE.Group();
    const body = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.12, 1.6, 6), mat(0xfbbf24));
    const tipWood = new THREE.Mesh(new THREE.ConeGeometry(0.12, 0.32, 6), mat(0xf5d0a9));
    tipWood.position.y = -0.96;
    tipWood.rotation.x = Math.PI;
    const lead = new THREE.Mesh(new THREE.ConeGeometry(0.04, 0.1, 6), mat(0x1f2937));
    lead.position.y = -1.08;
    lead.rotation.x = Math.PI;
    const ferrule = new THREE.Mesh(new THREE.CylinderGeometry(0.125, 0.125, 0.16, 16), mat(0xcbd5e1, { metalness: 0.8, roughness: 0.25 }));
    ferrule.position.y = 0.88;
    const eraser = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.12, 0.16, 16), mat(0xf472b6));
    eraser.position.y = 1.04;
    g.add(body, tipWood, lead, ferrule, eraser);
    return g;
}

// Atom: nucleus + three electron orbits (science / research)
export function makeAtom() {
    const g = new THREE.Group();
    g.add(new THREE.Mesh(new THREE.SphereGeometry(0.18, 24, 24), mat(0x38bdf8, { emissive: 0x0369a1, emissiveIntensity: 0.4 })));
    const ringMat = mat(0x7dd3fc, { metalness: 0.3 });
    const electrons = [];
    for (let i = 0; i < 3; i++) {
        const orbit = new THREE.Group();
        orbit.rotation.set((i * Math.PI) / 3, (i * Math.PI) / 5, 0);
        orbit.add(new THREE.Mesh(new THREE.TorusGeometry(0.75, 0.018, 8, 80), ringMat));
        const e = new THREE.Mesh(new THREE.SphereGeometry(0.07, 12, 12), mat(0xffffff, { emissive: 0x7dd3fc, emissiveIntensity: 0.8 }));
        orbit.add(e);
        electrons.push({ e, offset: i * 2.1 });
        g.add(orbit);
    }
    g.userData.update = (t) => electrons.forEach(({ e, offset }) => e.position.set(Math.cos(t * 1.6 + offset) * 0.75, Math.sin(t * 1.6 + offset) * 0.75, 0));
    return g;
}

// Paper plane: the "travel abroad" motif
export function makePlane() {
    const geo = new THREE.BufferGeometry();
    const v = new Float32Array([
        0, 0, 1.2, -0.9, 0, -0.6, 0, 0.05, -0.3,
        0, 0, 1.2, 0, 0.05, -0.3, 0.9, 0, -0.6,
        0, 0, 1.2, 0, 0.05, -0.3, 0, -0.35, -0.5,
    ]);
    geo.setAttribute('position', new THREE.BufferAttribute(v, 3));
    geo.computeVertexNormals();
    return new THREE.Mesh(geo, mat(0xffffff, { side: THREE.DoubleSide, roughness: 0.7 }));
}

export function makeGlobeMini() {
    const g = new THREE.Group();
    g.add(new THREE.Mesh(new THREE.SphereGeometry(0.6, 32, 32), mat(0x0369a1, { roughness: 0.4 })));
    g.add(new THREE.Mesh(new THREE.SphereGeometry(0.61, 16, 12), new THREE.MeshBasicMaterial({ color: 0x7dd3fc, wireframe: true, transparent: true, opacity: 0.35 })));
    const stand = new THREE.Mesh(new THREE.TorusGeometry(0.75, 0.025, 8, 60, Math.PI * 1.2), mat(0xfbbf24, { metalness: 0.6, roughness: 0.3 }));
    stand.rotation.z = -Math.PI * 0.1;
    g.add(stand);
    return g;
}
