// Selecting the sidenavbar and buttons
const sidenavbarfaq = document.querySelector(".sidenavbarfaq");

const sidenavbar = document.querySelector(".sidenavbar");
const sidenavbarLockBtn = document.querySelector("#lock-icon");
const header = document.querySelector("#header");
const mainPanel = document.querySelector(".main-panel");
const overlay = document.querySelector(".overlay");
var screensize= $( window ).width();

if(screensize<=800){
  $('#header').removeClass('header-open').addClass('header-close');
  $('.sidenavv-toggler #lock-icon').removeClass('fa-close').addClass('fa-bars');
  setTimeout(() => {
    $('.changewdth').removeClass('changewdth');
  }, 100);
}

if(sidenavbarfaq==null){
  
    // Collage Card profile
    const arrowtoggleBtn = document.querySelector('.toggle');
    const angletoggleBtn = document.querySelector('.angle-btn-toggle');


    if(screensize<=600){
      header.classList.replace("header-close", "header-unset");
    }

    // Function to toggle the lock state of the sidenavbar
    const toggleLock = () => {
      sidenavbar.classList.toggle("locked");
      // If the sidenavbar is not locked
      if(!sidenavbar.classList.contains("locked")) 
      {
        if(screensize<=600){
          header.classList.replace("header-open", "header-unset");
        }else{
          header.classList.replace("header-open", "header-close");
        }
        sidenavbar.classList.add("hoverable");
        sidenavbar.classList.add("close");
        sidenavbarLockBtn.classList.replace("fa-close", "fa-bars");
        if(screensize>800)
        {
          mainPanel.classList.add("main-panel-customize");
        }else{
          $('.navbar').removeClass('d-none');
          $('.overlay').removeClass('active');
        }
    } else {
        sidenavbar.classList.remove("hoverable");
        sidenavbar.classList.remove("close");
        sidenavbarLockBtn.classList.replace("fa-bars", "fa-close");
        if(screensize>800)
        {
          mainPanel.classList.remove("main-panel-customize");
        }else{
          $('.navbar').addClass('d-none');
          $('.overlay').addClass('active');
        }
        if(screensize<=600){
          header.classList.replace("header-unset", "header-open");
        }else{
          header.classList.replace("header-close", "header-open");
        }
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
      overlay.addEventListener("click", toggleLock);
    }

    if(arrowtoggleBtn!=null){
        arrowtoggleBtn.addEventListener("click", arrowToggle);
    }
}else{
    
    // Collage Card 
    if(screensize<768){
      header.classList.replace("header-unsets", "header-unset");
      sidenavbar.classList.remove("unsets");
      sidenavbar.classList.add("hoverable");
      sidenavbar.classList.add("close");
    }else{
      header.classList.replace("header-unsets", "header-open");
      sidenavbar.classList.remove("unsets");
      sidenavbar.classList.add("locked");
    }
  
    // Function to toggle the lock state of the sidenavbar
    const toggleLock = () => {
      sidenavbar.classList.toggle("locked");
      // If the sidenavbar is not locked
      if(!sidenavbar.classList.contains("locked")) 
      {
        header.classList.replace("header-open", "header-unset");
        sidenavbar.classList.add("hoverable");
        sidenavbar.classList.add("close");
        sidenavbarLockBtn.classList.replace("fa-close", "fa-bars");
        $('.navbar').removeClass('d-none');
        $('.overlay').removeClass('active');
      } else {
        header.classList.replace("header-unset", "header-open");
        sidenavbar.classList.remove("hoverable");
        sidenavbar.classList.remove("close");
        sidenavbarLockBtn.classList.replace("fa-bars", "fa-close");
        $('.navbar').addClass('d-none');
        $('.overlay').addClass('active');
      }
    };


    // If the window width is less than 800px, close the sidenavbar and remove hoverability and lock

    if(sidenavbar!=null){
      if (window.innerWidth < 768) {
        sidenavbar.classList.add("close");
        sidenavbar.classList.remove("open");
        sidenavbar.classList.remove("locked");
        sidenavbar.classList.remove("hoverable");
      }
    }

    // Adding event listeners to buttons and sidenavbar for the corresponding actions
    if(sidenavbarLockBtn!=null){
      sidenavbarLockBtn.addEventListener("click", toggleLock);
      overlay.addEventListener("click", toggleLock);
    }
}