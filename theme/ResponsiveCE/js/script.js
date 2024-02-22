const current = document.querySelector('.current a');
current.setAttribute('role', 'button');


/* nav mobile */

const headerMobileBtn = document.querySelector('.header-mobile-btn');
const headerNav = document.querySelector('.header-nav');

headerMobileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    console.log('test');

    headerNav.classList.toggle('hide-mobile');
})