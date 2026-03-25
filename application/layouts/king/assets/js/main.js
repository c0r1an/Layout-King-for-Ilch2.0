document.addEventListener('DOMContentLoaded', function () {
    var search = document.querySelector('.header-search');
    var searchToggle = document.querySelector('.header-search-toggle');
    var mobileTools = document.querySelector('.mobile-layout-tools');
    var mobileToggle = document.querySelector('.mobile-menu-toggle');

    if (search && searchToggle) {
        searchToggle.addEventListener('click', function () {
            search.classList.toggle('is-open');
        });

        document.addEventListener('click', function (event) {
            if (!search.contains(event.target)) {
                search.classList.remove('is-open');
            }
        });
    }

    if (mobileTools && mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            var isOpen = mobileTools.classList.toggle('is-open');
            mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }
});
