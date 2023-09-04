// carousel cua bai viet
$('#owl-carousel-post').owlCarousel({
    dots: true,
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 3000,
    marginBottom: 16,
    nav:true,
    navText: ["<i class='prev fa fa-angle-left'></i>", "<i class='next fa fa-angle-right'></i>"],
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 1
        },
        768: {
            items: 1
        },
        992: {
            items: 1
        },
        1200: {
            items: 1
        }
    }
})