// Selecting the sidenavbar and buttons
const sidenavbar = document.querySelector(".sidenavbar");
const sidenavbarOpenBtn = document.querySelector("#sidenavbar-open");
const sidenavbarCloseBtn = document.querySelector("#sidenavbar-close");
const sidenavbarLockBtn = document.querySelector("#lock-icon");
const header = document.querySelector("#header");
const mainPanel = document.querySelector(".main-panel");

const navbartoggleBtn = document.querySelector('.navbar-toggler');
const sidenavbartoggleBtn = document.querySelector('.sidenav-toggler');
const sidenavbarLockBtn1 = document.querySelector("#lock-icon1");

// Collage Card profile
const arrowtoggleBtn = document.querySelector('.toggle');
const angletoggleBtn = document.querySelector('.angle-toggle');

if(sidenavbar!=null){ 
  header.classList.add('header-open'); 
}
var screensize= $( window ).width();

if(screensize<=800)
{
  header.classList.replace("header-open", "header-close");
  if(mainPanel!=null){
    mainPanel.classList.add("main-panel-customize");
  }
  
  if(screensize<=600){
    header.classList.replace("header-close", "header-unset");
  }

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
} else {
    header.classList.replace("header-close", "header-open");
    sidenavbar.classList.remove("hoverable");
    sidenavbar.classList.remove("close");
    sidenavbarLockBtn.classList.replace("fa-bars", "fa-close");
    mainPanel.classList.remove("main-panel-customize");
  }
};

// Function to toggle the lock state of the sidenavbar
const toggleMobNavLock = () => {
  if (navbartoggleBtn.classList.contains("sidenavv-toggler")) {
    navbartoggleBtn.classList.remove('sidenavv-toggler');
    $('.sidenavbar').show();
    sidenavbarLockBtn1.classList.replace("fa-bars", "fa-close");
    header.classList.replace("header-unset", "header-close");  
  } else{
    navbartoggleBtn.classList.add('sidenavv-toggler');
    sidenavbarLockBtn1.classList.replace("fa-close", "fa-bars");
    $('.sidenavbar').hide();
    header.classList.replace("header-close", "header-unset"); 
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

if(sidenavbar!=null){
  if (window.innerWidth < 800) {
    sidenavbar.classList.add("close");
    sidenavbar.classList.remove("locked");
    sidenavbar.classList.remove("hoverable");
  }
// Adding event listeners to buttons and sidenavbar for the corresponding actions
  sidenavbar.addEventListener("mouseleave", hideSidenavbar);
  sidenavbar.addEventListener("mouseenter", showSidenavbar);
}

// Adding event listeners to buttons and sidenavbar for the corresponding actions
if(sidenavbarLockBtn!=null){
  sidenavbarLockBtn.addEventListener("click", toggleLock);
}
if(navbartoggleBtn!=null){
  navbartoggleBtn.addEventListener("click", toggleMobNavLock);
}
if(sidenavbartoggleBtn!=null){
  sidenavbartoggleBtn.addEventListener("click", toggleLock);
}
if(arrowtoggleBtn!=null){
  arrowtoggleBtn.addEventListener("click", arrowToggle);
}
// sidenavbarOpenBtn.addEventListener("click", toggleSidenavbar);
// sidenavbarCloseBtn.addEventListener("click", toggleSidenavbar);
