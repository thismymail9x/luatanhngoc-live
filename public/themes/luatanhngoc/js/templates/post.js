const contentCategory = document.getElementById('contentCategory');
const contentPost = $('#contentPost p');
const title = $('h1.title');

const maxFontSize = 28; // Giới hạn kích thước tối đa
const minFontSize = 12; // Giới hạn kích thước tối thiểu
$('.increaseSizeBtn').on('click',function () {
    $(this).css('color','#fff');
    $('.decreaseSizeBtn').css('color','unset');
    let currentSize = parseInt(getComputedStyle(contentPost[0]).fontSize);
    let currentSizeTitle = parseInt(getComputedStyle(title[0]).fontSize);
    if (currentSize < maxFontSize) {
        let cssProperty = 'font-size: '+(currentSize + 2)+'px !important;';
        let cssProperty2px = 'font-size: '+(currentSizeTitle + 2)+'px !important;';
        $('#contentPost *:not(div,img,em span),#contentPost,.introduce-blog').css('cssText',cssProperty);
        $('.title').css('cssText',cssProperty2px);
        $('#contentCategory *:not(div,img,em span),#contentCategory,.introduce-blog').css('cssText',cssProperty);
    }
});

$('.decreaseSizeBtn').on('click',function () {
    $(this).css('color','#fff');
    $('.increaseSizeBtn').css('color','unset');
    let currentSize = parseInt(getComputedStyle(contentPost[0]).fontSize);
    let currentSizeTitle = parseInt(getComputedStyle(title[0]).fontSize);
    if (currentSize > minFontSize) {
        let cssProperty = 'font-size: '+(currentSize - 2)+'px !important;';
        let cssProperty2px = 'font-size: '+(currentSizeTitle - 2)+'px !important;';
        $('#contentPost *,#contentPost,.introduce-blog,.title').css('cssText',cssProperty);
        $('.title').css('cssText',cssProperty2px);
        $('#contentCategory *,#contentCategory,.introduce-blog').css('cssText',cssProperty);

    }
});
window.addEventListener('load', function() {
    // ẩn hiện mục lục
    const contentCategory = document.getElementById('contentCategory');
    const menuCategory = document.getElementById('menuCategory');
    const itemTop = contentCategory.querySelector('.item-top');
    const iconRotate = contentCategory.querySelector('.icon__rotate');
    itemTop.addEventListener('click', function() {
        contentCategory.classList.toggle('collapsed');
        iconRotate.classList.toggle('rotate');
    });
    const tocLinks = contentCategory.querySelectorAll('a');

    tocLinks.forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const targetId = link.getAttribute('href').substring(1); // Xóa ký tự "#" ở đầu chuỗi
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                scrollTo(targetElement, 500); // Sử dụng hàm scrollTo với thời gian cuộn là 500ms (0.5 giây)
            }
        });
    });

    function scrollTo(element, duration) {
        const start = window.pageYOffset;
        const target = element.getBoundingClientRect().top + window.pageYOffset - 60;
        const startTime = 'now' in window.performance ? performance.now() : new Date().getTime();
        const easeInOutQuad = function (t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        };

        function scroll() {
            const currentTime = 'now' in window.performance ? performance.now() : new Date().getTime();
            const timeElapsed = currentTime - startTime;
            const percentage = Math.min(timeElapsed / duration, 1);
            const newPosition = easeInOutQuad(percentage, start, target - start, 1);
            window.scroll(0, newPosition);

            if (percentage < 1) {
                requestAnimationFrame(scroll);
            }
        }

        scroll();
    }
    // click menu bên phải:
    if (menuCategory) {
        const tocLinksMenu = menuCategory.querySelectorAll('a');
        tocLinksMenu.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const targetId = link.getAttribute('href').substring(1); // Xóa ký tự "#" ở đầu chuỗi
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    scrollTo(targetElement, 500); // Sử dụng hàm scrollTo với thời gian cuộn là 500ms (0.5 giây)
                }
            });
        });
    }

});
$('.bg-article').on('click',function () {
    $('.blog__content').toggleClass('short');
    $('.blog__content').toggleClass('showall');
    var currentText = $(".btn-seemore").text();

    // Kiểm tra nếu văn bản là "Nội dung mẫu", thay đổi thành "Văn bản mới"
    if (currentText === "Xem thêm ⮇") {
        $(".btn-seemore").text("Thu gọn ⮅");
    } else {
        // Nếu không, thay đổi thành "Nội dung mẫu"
        $(".btn-seemore").text("Xem thêm ⮇");
    }
});





$(document).ready(function () {
    // Bắt sự kiện scroll
    $(window).scroll(function () {
        scroll_post();
    });
});
//function scroll ẩn hiển menu
function scroll_post() {
    const contentPostBase = document.getElementById('contentPost');
    var scroll_top = window.scrollY || jQuery(window).scrollTop();
    if (scroll_top > contentPostBase.offsetTop) {
        jQuery("body").addClass("show-hide__menu");
        _global_js_eb.ebBgLazzyLoad(scroll_top);

    } else {
        jQuery("body").removeClass("show-hide__menu");
    }
}

