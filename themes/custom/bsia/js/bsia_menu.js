window.jQuery = window.$ = jQuery;

var Menu = Menu || {
    initialize: function () {
      var windowWidth = $(window).width();
      var mobile = true;

      if($('body').hasClass('non-mobile')){
        mobile = false;
      }

      if ($('#main-menu nav').hasClass('open')) {
          $('#main-menu nav').removeClass('open');
      }

      if(mobile === true){
        if(windowWidth >= mobileBp){
          $('.main-nav').hide();
          $('#main-menu nav').show();
          Menu.close();
        }
        else{
          $('.main-nav').show();
          $('#main-menu nav').hide();
          Menu.close();
        }

        $(".main-nav").off('click').on('click', function (e) {
          console.log(e);
          Menu.toggle();
        });
      }
      else{
          $('.main-nav').hide();
          $('nav').show();
          Menu.close();
      }
    },
    close: function(){
        if ($('#main-menu nav').hasClass('open')) {
            $('#main-menu nav').removeClass('open').hide();
        }
    },
    open: function() {
        if (!($('#main-menu nav').hasClass('open'))) {
          $('#main-menu nav').addClass('open').show();
        }
    },
    isOpen: function(){
        return $('#main-menu nav').hasClass('open');
    },
    toggle: function () {
        if (Menu.isOpen()) {
            Menu.close();
        }
        else {
            Menu.open();
        }
    },
};

