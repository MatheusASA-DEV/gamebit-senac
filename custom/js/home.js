const bannerSwiper = new Swiper("#banner-caroussel", {
    loop: true,
    allowTouchMove: true,
    autoplay: { delay: 5000 },
    pagination: { el: "#banner-pagination", clickable: true },
    navigation: { prevEl: "#b-pagination-prev", nextEl: "#b-pagination-next" },
    resizeObserver: true
});