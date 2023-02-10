jQuery(document).ready(function ($) {
  $('.nav-sub-term-yp li').click(function (event) {
    var data = $(this).attr('data-id');
		var currentClick = $(this).attr('data-nav');

    $('.'+currentClick+' .content-post-tab-yp').removeClass('active');
		$('.'+currentClick+' .nav-sub-term-yp li').removeClass('active');

    $(this).addClass('active');
    $('.'+currentClick+' .content-post-tab-yp[data-id="' + data + '"]').addClass('active');
  });

  $('.bottom_banner_nav li').click(function (event) {
    var data = $(this).attr('data-id');
		var currentClick = $(this).attr('data-nav');

    $('.content_bottom_banner').removeClass('active');
		$('.bottom_banner_nav li').removeClass('active');

    $(this).addClass('active');
    $('.content_bottom_banner[data-id="' + data + '"]').addClass('active');
  });


  // $('.minimize-banner').click(function() {
  //       $('#carousel_home_banner .swiper-wrapper').toggleClass('hide');
  //       $(this).toggleClass('active');
  //
  //       if ($('.minimize-banner').hasClass('active')) {
  //           $('.minimize-banner').text('ขยายแบนเนอร์');
  //       }
  //       else {
  //             $('.minimize-banner').text('ย่อแบนเนอร์');
  //       }
  // });


  $('.minimize-banner .box-1 svg').click(function() {
        $('#carousel_home_banner .swiper-wrapper').toggleClass('hide');
        $(this).parent().addClass('hide');

        $('.minimize-banner').toggleClass('active');
        $('.minimize-banner .box-2').removeClass('hide');
  });

  $('.minimize-banner .box-2 svg').click(function() {
        $('#carousel_home_banner .swiper-wrapper').toggleClass('hide');
        $(this).parent().addClass('hide');

        $('.minimize-banner').toggleClass('active');
        $('.minimize-banner .box-1').removeClass('hide');
  });



  $(window).on('scroll',function(){
      stop = Math.round($(window).scrollTop());
      if (stop > 70) {
      $('.minimize-banner.active').addClass('hide');
      } else {
      $('.minimize-banner.active').removeClass('hide');
      }
      });



});


var galleryTop = new Swiper('.gallery-top', {
  spaceBetween: 0,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  loop: true,
  loopedSlides: 4,
  autoHeight: true,
});
var galleryThumbs = new Swiper('.gallery-thumbs', {
  spaceBetween: 0,
  centeredSlides: true,
  slidesPerView: 'auto',
  touchRatio: 0.2,
  slideToClickedSlide: true,
  loop: true,
  loopedSlides: 4,
  autoHeight: true,
});
galleryTop.controller.control = galleryThumbs;
galleryThumbs.controller.control = galleryTop;
