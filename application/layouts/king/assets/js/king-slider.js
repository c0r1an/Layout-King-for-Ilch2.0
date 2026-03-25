document.addEventListener('DOMContentLoaded', function () {
    var slider = document.querySelector('.king-slider');

    if (!slider) {
        return;
    }

    var slides = Array.prototype.slice.call(slider.querySelectorAll('.king-slide'));
    var dots = Array.prototype.slice.call(slider.querySelectorAll('.king-slider-dot'));
    var prev = slider.querySelector('.king-slider-prev');
    var next = slider.querySelector('.king-slider-next');
    var currentIndex = 0;
    var intervalId = null;

    function showSlide(index) {
        currentIndex = (index + slides.length) % slides.length;

        slides.forEach(function (slide, slideIndex) {
            slide.classList.toggle('is-active', slideIndex === currentIndex);
        });

        dots.forEach(function (dot, dotIndex) {
            dot.classList.toggle('is-active', dotIndex === currentIndex);
        });
    }

    function startAutoPlay() {
        if (slides.length < 2) {
            return;
        }

        intervalId = window.setInterval(function () {
            showSlide(currentIndex + 1);
        }, 5000);
    }

    function resetAutoPlay() {
        if (intervalId) {
            window.clearInterval(intervalId);
        }

        startAutoPlay();
    }

    if (prev) {
        prev.addEventListener('click', function () {
            showSlide(currentIndex - 1);
            resetAutoPlay();
        });
    }

    if (next) {
        next.addEventListener('click', function () {
            showSlide(currentIndex + 1);
            resetAutoPlay();
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            showSlide(parseInt(dot.getAttribute('data-slide'), 10) || 0);
            resetAutoPlay();
        });
    });

    showSlide(0);
    startAutoPlay();
});
