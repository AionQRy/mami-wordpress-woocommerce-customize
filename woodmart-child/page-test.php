<?php /* Template Name: Example Template */ 
get_header();
?>

<div class="cpt-newsletter">
    <div class="grid-box">
        <div class="column-1">
            <div class="title">
                <div class="head-h2 t-1">CRT</div>
                <div class="head-h2 t-2">Newsletter</div>
            </div>    
            <div class="btn-read_all">
                <a href="#" class="link-read_all btn-orange">see all</a>
            </div>  
            <div class="swiper-pagination-box"></div>    
        </div>
        <div class="column-2">
 <!-- Swiper -->
    <div class="swiper carousel-cpt">
      <div class="swiper-wrapper">
        <div class="swiper-slide">Slide 1</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div>
      </div>
      <div class="swiper-pagination-box"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <style>
        .cpt-newsletter {
    position: relative;
    display: block;
}

.cpt-newsletter .grid-box {
    display: grid;
    grid-template-columns: 1fr 2fr;
    position: relative;
}

.cpt-newsletter .grid-box .column-1 {
    position: relative;
}

.cpt-newsletter .grid-box .column-2 {
    position: relative;
}
/*ipad (tablet)*/
@media (max-width: 1024px) {
    .cpt-newsletter .grid-box .column-1 {
        padding: 2em;
    }
    .cpt-newsletter .column-1 .title .head-h2 {
        font-size: 30px;
    }
}
/*iphone8 (smartphone)*/
@media (max-width: 767px) {
    
   
}
    </style>
    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".carousel-cpt", {
        centeredSlides: true,
        pagination: '.swiper-pagination-box',
        paginationClickable: true,
        paginationBulletRender: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
            slidesPerView: 1,
            spaceBetween: 20
            },
            // when window width is >= 640px
            760: {
            slidesPerView: 2,
            spaceBetween: 20
            },
            1140: {
            slidesPerView: 3,
            spaceBetween: 30
            }
        }
      });
    </script>
        </div>
    </div>
</div>

<?php
get_footer();