
// scroll menu header tổng
window.addEventListener('scroll', () => {
    const bborder = document.querySelector('.bborder');
    const scrollPosition = window.scrollY;
    if (bborder !== null)
        if (scrollPosition > 0) {
            bborder.classList.add('sticky');
        } else {
            bborder.classList.remove('sticky');
        }
});
// console.log('ccc')
window.addEventListener('scroll', () => {
    const mobile_fixed_menu = document.querySelector('.mobile-fixed-menu');
    const scrollPosition = window.scrollY;
    if (mobile_fixed_menu !== null) {
        if (scrollPosition > 0) {
            mobile_fixed_menu.classList.add('sticky');
        } else {
            mobile_fixed_menu.classList.remove('sticky');
        }
    }

});