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
          $('#main-menu').show();
          Menu.close();
        }
        else{
          $('.main-nav').show();
          $('#main-menu').hide();
          Menu.close();
        }

        $(".main-nav").off('click').on('click', function (e) {
          //console.log(e);
          Menu.toggle();
        });
      }
      else{
          $('.main-nav').hide();
          $('#main-menu').show();
          Menu.close();
      }
    },
    close: function(){
        if ($('#main-menu').hasClass('open')) {
            $('#main-menu').removeClass('open').hide();
        }
    },
    open: function() {
        if (!($('#main-menu').hasClass('open'))) {
          console.log('open class');
          $('#main-menu').addClass('open').show();
        }

    },
    isOpen: function(){
        return $('#main-menu').hasClass('open');
    },
    toggle: function () {
        console.log('toggle');
        if (Menu.isOpen()) {
            Menu.close();
            console.log('closing');
        }
        else {
            Menu.open();
            console.log('opening');
        }
    },
};

