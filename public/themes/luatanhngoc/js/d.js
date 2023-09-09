
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