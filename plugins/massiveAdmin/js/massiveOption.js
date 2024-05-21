document.querySelector('.hidecontent1').classList.add('hide');
document.querySelector('#hidetitle1').addEventListener('click', () => {
    if (document.querySelector('.hidecontent1').classList.contains('hide') == true) {
        document.querySelector('.hidecontent1').classList.remove('hide');
    } else {
        document.querySelector('.hidecontent1').classList.add('hide');
    }
});
document.querySelector('.hidecontent2').classList.add('hide');
document.querySelector('#hidetitle2').addEventListener('click', () => {
    if (document.querySelector('.hidecontent2').classList.contains('hide') == true) {
        document.querySelector('.hidecontent2').classList.remove('hide');
    } else {
        document.querySelector('.hidecontent2').classList.add('hide');
    }
});