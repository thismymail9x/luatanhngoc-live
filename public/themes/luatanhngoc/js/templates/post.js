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
    const itemTop = contentCategory.querySelector('.item-top');
    const iconRotate = contentCategory.querySelector('.icon__rotate');
    itemTop.addEventListener('click', function() {
        contentCategory.classList.toggle('collapsed');
        iconRotate.classList.toggle('rotate');
    });
    // click mục lục scroll đến offset 170px
    const tocLinks = contentCategory.querySelectorAll('a');
    tocLinks.forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const targetId = link.getAttribute('href').substring(1); // Xóa ký tự "_" ở đầu chuỗi
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const offset = targetElement.getBoundingClientRect().top + window.pageYOffset - 90;
                window.scrollTo({
                    top: offset,
                    behavior: 'smooth' // Thêm thuộc tính behavior để tạo hiệu ứng cuộn mượt mà
                });
            }
        });
    });
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