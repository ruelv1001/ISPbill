// resources/js/menu.js


document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('.nav-toggle');
    const element = document.querySelector('.navigation-menu');

    button.addEventListener('click', function () {
       
        if (window.innerWidth <= 1366) {
            button.classList.toggle('open');
            element.classList.toggle('open');
        } else {
            button.classList.toggle('close');
            element.classList.toggle('close');
        }
    });
});



function checkWindowSize() {
    const button = document.querySelector('.nav-toggle');
    const element = document.querySelector('.navigation-menu');
    if (window.innerWidth <= 1366) {
        button.classList.add('close');
        element.classList.add('close');
    } else {
        button.classList.remove('close');
        element.classList.remove('close');
    }
}


// Add event listener for resize
// window.addEventListener('resize', checkWindowSize);
// window.onload = checkWindowSize;

