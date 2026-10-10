// Light / dark theme toggle. The initial class is set inline in <head> to avoid a flash.
const root = document.documentElement;

function setTheme(dark) {
    root.classList.toggle('dark', dark);
    try { localStorage.setItem('dj-theme', dark ? 'dark' : 'light'); } catch (e) {}
    window.dispatchEvent(new CustomEvent('dj:theme', { detail: { dark } }));
}

function toggle(e) {
    const dark = !root.classList.contains('dark');
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Circular reveal from the button where View Transitions are supported
    if (document.startViewTransition && !reduce) {
        const r = e.currentTarget.getBoundingClientRect();
        const x = r.left + r.width / 2, y = r.top + r.height / 2;
        const radius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));
        const vt = document.startViewTransition(() => setTheme(dark));
        vt.ready.then(() => {
            root.animate(
                { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${radius}px at ${x}px ${y}px)`] },
                { duration: 650, easing: 'cubic-bezier(0.77, 0, 0.175, 1)', pseudoElement: '::view-transition-new(root)' }
            );
        });
        return;
    }
    root.classList.add('theme-anim');
    setTheme(dark);
    setTimeout(() => root.classList.remove('theme-anim'), 500);
}

export function initTheme() {
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        if (btn.dataset.bound) return;
        btn.dataset.bound = '1';
        btn.addEventListener('click', toggle);
    });

    // Follow the OS setting until the visitor makes an explicit choice
    const mq = window.matchMedia('(prefers-color-scheme: dark)');
    if (!initTheme.bound) {
        initTheme.bound = true;
        mq.addEventListener('change', (ev) => {
            let saved = null;
            try { saved = localStorage.getItem('dj-theme'); } catch (e) {}
            if (!saved) {
                root.classList.toggle('dark', ev.matches);
                window.dispatchEvent(new CustomEvent('dj:theme', { detail: { dark: ev.matches } }));
            }
        });
    }
}
