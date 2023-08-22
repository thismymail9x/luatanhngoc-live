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
console.log('ccc')