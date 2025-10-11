//   navbar function 
$(document).ready(function(){

    $('.fa-bars').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('scroll load',function(){
        $('.fa-bars').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if($(Window).scrollTop()  >  30){
            $('header').addClass('header-active');
        }else{
            $('header').removeClass('header-active');
        }
    });

    
});

// Get elements
const menuIcon = document.getElementById('menuIcon');
const navMenu = document.getElementById('navMenu');

// Toggle dropdown when icon clicked
menuIcon.addEventListener('click', () => {
  navMenu.classList.toggle('show');
});

// Optional: Close dropdown when clicking outside
window.addEventListener('click', (e) => {
  if (!menuIcon.contains(e.target) && !navMenu.contains(e.target)) {
    navMenu.classList.remove('show');
  }
});