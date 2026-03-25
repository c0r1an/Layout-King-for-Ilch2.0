document.addEventListener('DOMContentLoaded', function () {
    var button = document.querySelector('.to-top');

    if (!button) {
        return;
    }

    function updateVisibility() {
        button.classList.toggle('is-visible', window.scrollY > 120);
    }

    button.addEventListener('click', function (event) {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', updateVisibility, { passive: true });
    updateVisibility();
});
