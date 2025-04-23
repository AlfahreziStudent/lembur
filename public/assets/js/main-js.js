// ketika hamburger di click
const navbarNav = document.querySelector('.navbars');

document.querySelector('#hamburger').
onclick = () => {
    navbarNav.classList.toggle('actives');
};


const hamburger = document.querySelector
('#hamburger');

document.addEventListener('click', function(e){
    if(!hamburger.contains(e.target) && !navbarNav.contains(e.target)){
    navbarNav.classList.remove('actives');
    }

});

let subMenu = document.getElementById("subMenu");

function toggleMenu(){
    subMenu.classList.toggle("open-menu");
}

