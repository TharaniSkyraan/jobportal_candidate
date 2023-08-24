  // Selecting the sidenavbar and buttons
  const sidenavbarfaq = document.querySelector(".sidenavbarfaq");

  const sidenavbar = document.querySelector(".sidenavbar");
  const sidenavbarLockBtn = document.querySelector("#locked-icon");
  const mainPanel = document.querySelector(".main-panel");
  const overlay = document.querySelector(".overlay");

  var screensize= $( window ).width();

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
      $('.overlay').removeClass('active');
      $('.searchinput').show();
  } else {
      header.classList.replace("header-unset", "header-open");
      sidenavbar.classList.remove("hoverable");
      sidenavbar.classList.remove("close");
      sidenavbarLockBtn.classList.replace("fa-bars", "fa-close");
      $('.overlay').addClass('active');
      $('.searchinput').hide();
    }
  };


  // Function to show and hide the sidenavbar
  const toggleSidenavbar = () => {
    sidenavbar.classList.toggle("close");
  };

  // If the window width is less than 800px, close the sidenavbar and remove hoverability and lock
  // if(sidenavbar!=null){
  //   if (window.innerWidth < 800) {
  //     sidenavbar.classList.add("close");
  //     sidenavbar.classList.remove("locked");
  //     sidenavbar.classList.remove("hoverable");
  //   }
  // }

  // Adding event listeners to buttons and sidenavbar for the corresponding actions
  if(sidenavbarLockBtn!=null){
    sidenavbarLockBtn.addEventListener("click", toggleLock);
    overlay.addEventListener("click", toggleLock);
  }