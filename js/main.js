/* ============================================================
   ООО «Эксперт канатной резки» — интерактив
   ============================================================ */
(function () {
    'use strict';

    var body = document.body;

    /* ---------- Год в подвале ---------- */
    var yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    /* ============================================================
       БУРГЕР-МЕНЮ
       ============================================================ */
    var burger = document.getElementById('burger');
    var nav = document.getElementById('mainNav');
    var navOverlay = document.getElementById('navOverlay');

    function openNav() {
        nav.classList.add('is-open');
        burger.classList.add('is-open');
        burger.setAttribute('aria-expanded', 'true');
        navOverlay.hidden = false;
        requestAnimationFrame(function () { navOverlay.classList.add('is-visible'); });
    }
    function closeNav() {
        nav.classList.remove('is-open');
        burger.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        navOverlay.classList.remove('is-visible');
        setTimeout(function () { navOverlay.hidden = true; }, 300);
    }
    if (burger) {
        burger.addEventListener('click', function () {
            nav.classList.contains('is-open') ? closeNav() : openNav();
        });
        navOverlay.addEventListener('click', closeNav);
        // закрытие меню при клике по пункту (моб. версия)
        nav.querySelectorAll('.nav__link').forEach(function (link) {
            link.addEventListener('click', closeNav);
        });
    }

    /* ============================================================
       ПЛАВНАЯ ПРОКРУТКА ПО ЯКОРЯМ
       ============================================================ */
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var id = link.getAttribute('href');
            if (id === '#' || id.length < 2) return;
            var target = document.querySelector(id);
            if (!target) return;
            e.preventDefault();
            var headerH = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-h')) || 80;
            var top = target.getBoundingClientRect().top + window.pageYOffset - headerH + 2;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    });

    /* ============================================================
       КНОПКА «НАВЕРХ»
       ============================================================ */
    var toTop = document.getElementById('toTop');
    if (toTop) {
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 600) { toTop.hidden = false; }
            else { toTop.hidden = true; }
        }, { passive: true });
        toTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ============================================================
       МОДАЛЬНАЯ ФОРМА ЗАЯВКИ
       ============================================================ */
    var modal = document.getElementById('modal');
    var form = document.getElementById('requestForm');
    var lastFocused = null;

    function openModal() {
        lastFocused = document.activeElement;
        modal.hidden = false;
        body.classList.add('no-scroll');
        closeNav();
        var first = modal.querySelector('input, textarea, button');
        if (first) setTimeout(function () { first.focus(); }, 60);
    }
    function closeModal() {
        modal.hidden = true;
        body.classList.remove('no-scroll');
        if (lastFocused) lastFocused.focus();
    }

    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', openModal);
    });
    if (modal) {
        modal.querySelectorAll('[data-close-modal]').forEach(function (el) {
            el.addEventListener('click', closeModal);
        });
    }

    /* ---------- Маска телефона (для обычной формы и для Contact Form 7) ---------- */
    function applyPhoneMask(phoneInput) {
        if (!phoneInput) return;
        phoneInput.addEventListener('input', function () {
            var digits = phoneInput.value.replace(/\D/g, '');
            if (digits.startsWith('8')) digits = '7' + digits.slice(1);
            if (!digits.startsWith('7')) digits = '7' + digits;
            digits = digits.slice(0, 11);
            var out = '+7';
            if (digits.length > 1) out += ' (' + digits.slice(1, 4);
            if (digits.length >= 4) out += ') ' + digits.slice(4, 7);
            if (digits.length >= 7) out += '-' + digits.slice(7, 9);
            if (digits.length >= 9) out += '-' + digits.slice(9, 11);
            phoneInput.value = out;
        });
        phoneInput.addEventListener('focus', function () {
            if (!phoneInput.value) phoneInput.value = '+7 ';
        });
    }
    applyPhoneMask(document.getElementById('fPhone'));   // HTML-форма
    applyPhoneMask(document.getElementById('cf7Phone')); // Contact Form 7

    /* ---------- Валидация и отправка ---------- */
    function setError(field, message) {
        var input = document.getElementById(field);
        var errEl = document.querySelector('[data-error-for="' + field + '"]');
        if (input) input.classList.add('is-invalid');
        if (errEl) errEl.textContent = message || '';
    }
    function clearError(field) {
        var input = document.getElementById(field);
        var errEl = document.querySelector('[data-error-for="' + field + '"]');
        if (input) input.classList.remove('is-invalid');
        if (errEl) errEl.textContent = '';
    }

    if (form) {
        ['fName', 'fPhone', 'fAgree'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('input', function () { clearError(id); });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var ok = true;

            // honeypot — если заполнен, тихо прерываем
            var hp = document.getElementById('fCompany');
            if (hp && hp.value.trim() !== '') return;

            var name = document.getElementById('fName');
            if (!name.value.trim()) { setError('fName', 'Пожалуйста, укажите имя'); ok = false; }

            var phone = document.getElementById('fPhone');
            var phoneDigits = phone.value.replace(/\D/g, '');
            if (phoneDigits.length < 11) { setError('fPhone', 'Введите корректный номер телефона'); ok = false; }

            var agree = document.getElementById('fAgree');
            if (!agree.checked) { setError('fAgree', 'Необходимо согласие на обработку данных'); ok = false; }

            if (!ok) return;

            /* На этапе верстки заявка не отправляется на сервер.
               Отправка на email администратора и дублирование в Telegram
               будут подключены на этапе интеграции с WordPress. */
            var successEl = document.getElementById('formSuccess');
            form.querySelectorAll('.form__field, .form__checkbox, .btn').forEach(function (el) {
                el.style.display = 'none';
            });
            if (successEl) successEl.hidden = false;
            setTimeout(closeModal, 3200);
        });
    }

    /* ============================================================
       ГАЛЕРЕЯ + LIGHTBOX
       ============================================================ */
    var track = document.getElementById('galleryTrack');
    var galPrev = document.getElementById('galPrev');
    var galNext = document.getElementById('galNext');
    var galItems = track ? Array.prototype.slice.call(track.querySelectorAll('.gallery__item')) : [];

    var images = galItems.map(function (item) {
        var img = item.querySelector('img');
        return { src: img.getAttribute('src'), alt: img.getAttribute('alt') };
    });

    /* ---- прокрутка ленты стрелками ---- */
    function scrollAmount() {
        var first = track.querySelector('.gallery__item');
        return first ? first.getBoundingClientRect().width + 16 : 300;
    }
    function updateGalArrows() {
        if (!galPrev || !galNext) return;
        galPrev.disabled = track.scrollLeft <= 4;
        galNext.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
    }
    if (track) {
        if (galPrev) galPrev.addEventListener('click', function () { track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' }); });
        if (galNext) galNext.addEventListener('click', function () { track.scrollBy({ left: scrollAmount(), behavior: 'smooth' }); });
        track.addEventListener('scroll', updateGalArrows, { passive: true });
        window.addEventListener('resize', updateGalArrows);
        updateGalArrows();
    }

    /* ---- lightbox ---- */
    var lightbox = document.getElementById('lightbox');
    var lbImage = document.getElementById('lbImage');
    var lbCounter = document.getElementById('lbCounter');
    var lbClose = document.getElementById('lbClose');
    var lbPrev = document.getElementById('lbPrev');
    var lbNext = document.getElementById('lbNext');
    var current = 0;

    function showImage(i) {
        current = (i + images.length) % images.length;
        lbImage.setAttribute('src', images[current].src);
        lbImage.setAttribute('alt', images[current].alt);
        if (lbCounter) lbCounter.textContent = (current + 1) + ' / ' + images.length;
    }
    function openLightbox(i) {
        showImage(i);
        lightbox.hidden = false;
        body.classList.add('no-scroll');
        lbClose.focus();
    }
    function closeLightbox() {
        lightbox.hidden = true;
        body.classList.remove('no-scroll');
    }

    galItems.forEach(function (item) {
        item.addEventListener('click', function () {
            openLightbox(parseInt(item.getAttribute('data-index'), 10) || 0);
        });
    });
    if (lbClose) lbClose.addEventListener('click', closeLightbox);
    if (lbPrev) lbPrev.addEventListener('click', function () { showImage(current - 1); });
    if (lbNext) lbNext.addEventListener('click', function () { showImage(current + 1); });
    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox__figure')) closeLightbox();
        });
        // свайп на мобильных
        var startX = 0;
        lightbox.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
        lightbox.addEventListener('touchend', function (e) {
            var dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 50) { dx < 0 ? showImage(current + 1) : showImage(current - 1); }
        }, { passive: true });
    }

    /* ============================================================
       КЛАВИАТУРА (Esc / стрелки)
       ============================================================ */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (modal && !modal.hidden) closeModal();
            if (lightbox && !lightbox.hidden) closeLightbox();
            if (nav && nav.classList.contains('is-open')) closeNav();
        }
        if (lightbox && !lightbox.hidden) {
            if (e.key === 'ArrowLeft') showImage(current - 1);
            if (e.key === 'ArrowRight') showImage(current + 1);
        }
    });

    /* ============================================================
       CONTACT FORM 7: закрыть модалку после успешной отправки
       ============================================================ */
    document.addEventListener('wpcf7mailsent', function () {
        if (modal && !modal.hidden) setTimeout(closeModal, 2800);
    });

})();
