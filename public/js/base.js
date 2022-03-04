console.log("hello toto");

const burgerBtn = document.querySelector('#burgerBtn');
const burgerMenu = document.querySelector('.burgerMenu');
let burgerStatus = false;

burgerBtn.addEventListener('click', () => {
    if (!burgerStatus) {
        burgerMenu.style.display = "flex";
        burgerStatus = true;
    } else {
        burgerMenu.style.display = "none";
        burgerStatus = false;
    }
});