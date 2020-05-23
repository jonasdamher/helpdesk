'use strict';

$(function(){

// DROPDOWN
$('body').on('click','.btn-dropdown', function() {
  let dropdown = $(this).siblings('.dropdown-list');
  if($(dropdown).hasClass('d-none') ) { 
    $(dropdown).fadeIn('fast', function(){
      $(dropdown).removeClass('d-none');
    });
  } else {
    $(dropdown).fadeOut('fast', function(){
      $(dropdown).addClass('d-none');
    });
  }
});

$('.dropdown-list').on('click', 'a', function() {
  let dropdown = $(this).parents('.dropdown-list');
  $(dropdown).fadeOut('fast', function(){
    $(dropdown).addClass('d-none');
  });
});

// FINAL DROPDOWN

// MENU PRINCIPAL
$('.btn-navbar').on('click', function(){
  var nav = $('.navbar-main').children('.navbar');

  if($('.navbar-main').hasClass('navbar-main-visible') ) {
    $(nav).toggleClass('navbar-animate');
    setTimeout(()=> { 
      $('.navbar-main').toggleClass('navbar-main-visible');
    },200);
  }else{
    $('.navbar-main').toggleClass('navbar-main-visible');
    setTimeout(()=> { $(nav).toggleClass('navbar-animate');},200);
  }
});

});