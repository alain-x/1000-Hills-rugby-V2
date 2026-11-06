document.addEventListener('DOMContentLoaded', function () {
    // Sticky navigation shadow
    const navbar = document.querySelector('.site-navbar');
    if (navbar) {
        const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 12);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Reveal on scroll
    const revealItems = document.querySelectorAll('.reveal');
    if (revealItems.length) {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            revealItems.forEach((item) => observer.observe(item));
        } else {
            revealItems.forEach((item) => item.classList.add('visible'));
        }
    }

    // Animated counters
    document.querySelectorAll('[data-counter]').forEach(function (el) {
        const target = parseInt(el.getAttribute('data-counter'), 10) || 0;
        let started = false;
        const run = () => {
            if (started) return;
            started = true;
            const duration = 1100;
            const start = performance.now();
            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(target * eased).toLocaleString();
                if (progress < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        };
        if ('IntersectionObserver' in window) {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) { run(); obs.disconnect(); }
                });
            }, { threshold: 0.4 });
            obs.observe(el);
        } else {
            run();
        }
    });

    // Auto-dismiss flash alerts
    document.querySelectorAll('.alert-dismissible[data-autohide]').forEach(function (el) {
        setTimeout(function () {
            if (window.bootstrap && window.bootstrap.Alert) {
                window.bootstrap.Alert.getOrCreateInstance(el).close();
            }
        }, 6000);
    });

    // Copy link buttons
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const text = btn.getAttribute('data-copy');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function () {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-check2"></i> Copied';
                    setTimeout(() => { btn.innerHTML = original; }, 1800);
                });
            }
        });
    });
});
