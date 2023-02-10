jQuery(document).ready(function($) {

    $('#benefit').addClass('active');
    $('.tab-list:first-child').addClass('active');

    const tabs = document.querySelectorAll('[data-tab-target]')
    const tabContents = document.querySelectorAll('[data-tab-content]')

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = document.querySelector(tab.dataset.tabTarget)
        tabContents.forEach(tabContent => {
          tabContent.classList.remove('active')
        })
        tabs.forEach(tab => {
          tab.classList.remove('active')
        })
        tab.classList.add('active')
        target.classList.add('active')
      })
    })


    $('.login-mm a').click(function(e) {
      e.preventDefault();
      $('.login-form-side').toggleClass('wd-opened');
      $('.wd-close-side').toggleClass('wd-close-side-opened');
      $('.wd-close-side').toggleClass('woodmart-close-side');
      $('.login-form-side .login').toggleClass('hidden-form');
    });

    $('.wd-close-side,.close-side-widget').click(function(event) {
          $('.login-form-side .login').addClass('hidden-form');
    });

});
