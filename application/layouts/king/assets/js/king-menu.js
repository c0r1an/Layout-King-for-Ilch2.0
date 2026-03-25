document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('.menu-toggle');
    var menu = document.querySelector('.menu-shell');

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', function () {
        var isOpen = menu.classList.toggle('is-open');
        toggle.classList.toggle('is-open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
});
