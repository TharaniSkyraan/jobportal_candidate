// Selecting the sidenavbar and buttons
const sidenavbar = document.querySelector(".sidenavbar");
const sidenavbarOpenBtn = document.querySelector("#sidenavbar-open");
const sidenavbarCloseBtn = document.querySelector("#sidenavbar-close");
const sidenavbarLockBtn = document.querySelector("#lock-icon");
const header = document.querySelector("#header");
const mainPanel = document.querySelector(".main-panel");
const sidenavbartoggleBtn = document.querySelector('.sidenav-toggler');
const arrowtoggleBtn = document.querySelector('.toggle');
const angletoggleBtn = document.querySelector('.angle-toggle');
if(sidenavbar!=null){ 
  // $('.img-fluid').show();
  header.classList.add('header-open'); 
}
var screensize= $( window ).width();

if(screensize<=800){
  header.classList.replace("header-open", "header-close");
  mainPanel.classList.add("main-panel-customize");
  // $('.img-fluid').show();
}

// Function to toggle the lock state of the sidenavbar
const toggleLock = () => {
  sidenavbar.classList.toggle("locked");
  // If the sidenavbar is not locked
  if (!sidenavbar.classList.contains("locked")) {
    header.classList.replace("header-open", "header-close");
    sidenavbar.classList.add("hoverable");
    sidenavbar.classList.add("close");
    sidenavbarLockBtn.classList.replace("fa-close", "fa-bars");
    mainPanel.classList.add("main-panel-customize");
    // $('.img-fluid').show();
} else {
    header.classList.replace("header-close", "header-open");
    sidenavbar.classList.remove("hoverable");
    sidenavbar.classList.remove("close");
    sidenavbarLockBtn.classList.replace("fa-bars", "fa-close");
    mainPanel.classList.remove("main-panel-customize");
    // $('.img-fluid').hide();
  }
};

// Function to toggle the lock state of the sidenavbar
const arrowToggle = () => {

  if (angletoggleBtn.classList.contains("fa-angle-up")) {
    angletoggleBtn.classList.replace("fa-angle-up", "fa-angle-down");
  }else{
    angletoggleBtn.classList.replace("fa-angle-down", "fa-angle-up");
  }

}
// Function to hide the sidenavbar when the mouse leaves
const hideSidenavbar = () => {
  if (sidenavbar.classList.contains("hoverable")) {
    // sidenavbar.classList.add("close");
  }
};

// Function to show the sidenavbar when the mouse enter
const showSidenavbar = () => {
  if (sidenavbar.classList.contains("hoverable")) {
    // sidenavbar.classList.remove("close");
  }
};

// Function to show and hide the sidenavbar
const toggleSidenavbar = () => {
  sidenavbar.classList.toggle("close");
};

// If the window width is less than 800px, close the sidenavbar and remove hoverability and lock
if (window.innerWidth < 800) {
  sidenavbar.classList.add("close");
  sidenavbar.classList.remove("locked");
  sidenavbar.classList.remove("hoverable");
}

// Adding event listeners to buttons and sidenavbar for the corresponding actions
sidenavbarLockBtn.addEventListener("click", toggleLock);
sidenavbartoggleBtn.addEventListener("click", toggleLock);
arrowtoggleBtn.addEventListener("click", arrowToggle);
sidenavbar.addEventListener("mouseleave", hideSidenavbar);
sidenavbar.addEventListener("mouseenter", showSidenavbar);
// sidenavbarOpenBtn.addEventListener("click", toggleSidenavbar);
// sidenavbarCloseBtn.addEventListener("click", toggleSidenavbar);
