const current = document.querySelector('.current a');
current.setAttribute('role', 'button');


/* nav mobile */

const headerMobileBtn = document.querySelector('.header-mobile-btn');
const headerNav = document.querySelector('.header-nav');

headerMobileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    headerNav.classList.toggle('hide-mobile');
});


/*dropdown icon */

const media = window.matchMedia("(min-width: 1200px)");


if (document.querySelector('.wSub')) {

    if (media.matches) {
        document.querySelectorAll('.wSub').forEach(menuItem => {

            menuItem.querySelector('a').insertAdjacentHTML('beforeend', '<i class="fas fa-chevron-down fa-xs" style="margin-left:5px"></i>');

        })
    } else {

        document.querySelectorAll('.wSub').forEach(menuItem => {

            menuItem.querySelector('a').insertAdjacentHTML('afterend', '<button class="showDropdown"><i class="fas fa-chevron-down fa-xs"></i></button>');

        })

    };


};



if (document.querySelector('.showDropdown')) {

    document.querySelectorAll('.showDropdown').forEach((x, i) => {


        x.addEventListener('click', (e) => {
            e.preventDefault();
            if (document.querySelectorAll('.subMenu')[i].style.display === 'none' || document.querySelectorAll('.subMenu')[i].style.display === '') {
                document.querySelectorAll('.subMenu')[i].style.display = "flex";
            } else {
                document.querySelectorAll('.subMenu')[i].style.display = "none";
            }
        })


    });

};