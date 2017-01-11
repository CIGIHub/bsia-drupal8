(function ($) {
     $(document).ready(function () {
         Menu.initialize();

    //add placeholder text for search box and faculty/student exposed views
        if($('#search-block-form').length > 0){
            var searchBlockForm = $('#search-block-form input');
            searchBlockForm.attr('placeholder', 'Search');

            searchBlockForm.focus(function(){
                if (searchBlockForm.attr('placeholder') === 'Search') {
                    searchBlockForm.attr('placeholder','');
                }
            }).blur(function(){
                if (searchBlockForm.attr('placeholder') === '') {
                    searchBlockForm.attr('placeholder', 'Search');
                }
            });
            
        }   

        if($('#views-exposed-form-faculty-page-2 input').length > 0 || $('#views-exposed-form-students-page-2 input').length > 0){
            
            var personBlockForm = null;
            var placeholderText = "";

            if($('#views-exposed-form-faculty-page-2 .form-text').length > 0){
                personBlockForm = $('#views-exposed-form-faculty-page-2 .form-text');
                placeholderText = 'Search All Faculty';
            }
            else if($('#views-exposed-form-students-page-2 .form-text').length > 0){
                personBlockForm = $('#views-exposed-form-students-page-2 .form-text');
                placeholderText = 'Search All Students';
            }

            var clearButton = $('<i class="fa fa-times-circle" id="clear-button"></i>');
            clearButton.insertAfter(personBlockForm).hide(); 
            personBlockForm.attr('placeholder', placeholderText);

            personBlockForm.focus(function(){
            
            if (personBlockForm.attr('placeholder') === placeholderText) {
                personBlockForm.attr('placeholder','');
                personBlockForm.keydown(function(){
                    clearButton.show();
                });
                }
            }).blur(function(){
                if (personBlockForm.attr('placeholder') === '') {
                    personBlockForm.attr('placeholder', placeholderText);
                 
                }
            });

            clearButton.click(function() {
                personBlockForm.val("");
                clearButton.hide();
            });
        }

    //add markup to first part of strings on gallery feature lines on homepage
        if($('#gallery li .box a').length){

            $('#gallery li .box a').each(function(){
                var originalText = $(this).text(); 
                var pieces = originalText.split(":");
                var newText = '<span class="label">' + pieces[0] + ':</span>' + pieces[1];
                $(this).html(newText);
            });
        }

        
        var page_url = window.location.pathname;
     
        $(".alphalist a").each(function () {
            if ($(this).attr("href") === page_url) {
                $(this).attr("href", "#");
                $(this).addClass("active");
            }
            
        });
        
        //Research anchors
        if($(".research-listing").length > 0){
            $('.research-listing h3:first').attr('id', 'cluster');
            $('.research-listing h3:last').attr('id', 'projects');
        }
        if($(".view-research.view-display-id-block_2").length > 0){
            $('.view-display-id-block_2 h3').attr('id', 'centres');
        }

        //Calendar drop down on events nodes
         $(".calendar dd").hide();
         $("dl.calendar").hover(
            function () {
                $(".calendar dd").show();
            },
            function () {
                $(".calendar dd").hide();
            }
         );


         if ($("a.vimeo").length > 0) {
             $("a.vimeo").colorbox({iframe: true, innerWidth: 625, innerHeight: 444});
         }
     });

     //highlight side Menu

     if($(".right-menu ul.menu").length > 0){
         var path = window.location.pathname;
         var link = "";
         $(".right-menu ul.menu li a").removeClass("is-active");
         $( ".right-menu ul.menu li a" ).each(function( index ) {

            //console.log( index + ": " + $( this ).attr('href') );
            if($( this ).attr('href') === path){
                $(this).addClass("is-active");
                $(this).parent().addClass(" menu-item--active-trail");
            }
        });
     }

    //scroll to anchors
    $("a[href*='#']:not([href='#'])").click(function() {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
                }, 1000);
            return false;
        }
    });

    $(window).resize(function () {
        Menu.initialize();
    });

 })(jQuery);
