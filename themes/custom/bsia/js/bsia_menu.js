window.jQuery = window.$ = jQuery;

var Menu = Menu || {
    initialize: function () {
      var windowWidth = $(window).width();
      var mobile = true;
      var mobileBp = 940;

      if($('body').hasClass('non-mobile')){
        mobile = false;
      }

      if ($('#main-menu').hasClass('open')) {
          $('#main-menu').removeClass('open');
      }

      if ($('.search-box').hasClass('open')) {
          $('.search-box').removeClass('open');
          $('.search-box').hide();
      }

      if(mobile === true){
        if(windowWidth >= mobileBp){
          $('.main-nav').hide();
          $('.search-button').hide();
          $('#main-menu').show();
          Menu.close($('#main-menu'));
        }
        else{
          $('.main-nav').show();
          $('.search-button').show();
          $('#main-menu').hide();
          Menu.close($('#main-menu'));
        }

        var button = null;
        $(".main-nav").off('click').on('click', function () {
          button = 'menu';
          Menu.toggle(button);
        });

        $(".search-button").off('click').on('click', function () {
          button = 'search';
          Menu.toggle(button);
        });
        
      }
      else{
          $('.main-nav').hide();
          $('.search-button').hide();
          $('#main-menu').show();
          Menu.close($('#main-menu'));
      }
    },
    close: function(selectedItem){
        if (selectedItem.hasClass('open')) {
          selectedItem.removeClass('open').hide();
          if (selectedItem.hasClass('search-box')) {
            $('.search-button i').addClass('fa-search').removeClass('fa-close');
          }
          if (selectedItem.is('#main-menu')) {
            $('.main-nav i').addClass('fa-list').removeClass('fa-close');
          }
        }
    },
    open: function(selectedItem) {
        if (!(selectedItem.hasClass('open'))) {
          selectedItem.addClass('open').show();
          if (selectedItem.hasClass('search-box')) {
            $('.search-button i').addClass('fa-close').removeClass('fa-search');
          }
          if (selectedItem.is('#main-menu')) {
            $('.main-nav i').addClass('fa-close').removeClass('fa-list');
          }
        }
    },
    isOpen: function(selectedItem){
        return selectedItem.hasClass('open');
    },
    toggle: function (button) {
      var selectedItem = null;
      if(button === 'menu'){
        selectedItem = $('#main-menu');
        if($('.search-box').hasClass('open')){
          Menu.close($('.search-box'));
        }
      }
      if(button === 'search'){
        selectedItem = $('.search-box');
        if($('#main-menu').hasClass('open')){
          Menu.close($('#main-menu'));
        }
      }

      if (Menu.isOpen(selectedItem)) {
          Menu.close(selectedItem);
      }
      else {
          Menu.open(selectedItem);
      }
    },
};

