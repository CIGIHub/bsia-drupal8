 var mobileBp = 940;

 (function ($) {
     $(document).ready(function () {
         Menu.initialize();

    //add placeholder text for search box and faculty/student exposed views
        if($('#search-block-form').length > 0){
            searchBlockForm = $('#search-block-form input');
            searchBlockForm.attr('placeholder', 'Search');

            searchBlockForm.focus(function(){
                if (searchBlockForm.attr('placeholder') == 'Search') {
                    searchBlockForm.attr('placeholder','');
                }
            }).blur(function(){
                if (searchBlockForm.attr('placeholder') == '') {
                    searchBlockForm.attr('placeholder', 'Search');
                }
            });
            
        }   

        if($('#views-exposed-form-faculty-page-2 input').length > 0 || $('#views-exposed-form-students-page-2 input').length > 0){
            console.log('here');
            if($('#views-exposed-form-faculty-page-2 .form-text').length > 0){
                personBlockForm = $('#views-exposed-form-faculty-page-2 .form-text');
                placeholderText = 'Search All Faculty';
            }
            else if($('#views-exposed-form-students-page-2 .form-text').length > 0){
                personBlockForm = $('#views-exposed-form-students-page-2 .form-text');
                placeholderText = 'Search All Students';
            }

            clearButton = $('<i class="fa fa-times-circle" id="clear-button"></i>');
            clearButton.insertAfter(personBlockForm).hide();
            personBlockForm.attr('placeholder', placeholderText);

            personBlockForm.focus(function(){
            current_base_page = window.location.href;
            console.log(current_base_page);

            if (personBlockForm.attr('placeholder') == placeholderText) {
                personBlockForm.attr('placeholder','');
                personBlockForm.keydown(function(){
                    clearButton.show();
                });
                }
            }).blur(function(){
                if (personBlockForm.attr('placeholder') == '') {
                    personBlockForm.attr('placeholder', placeholderText);
                 
                }
            });

            clearButton.click(function() {
                personBlockForm.val("");
                clearButton.hide();
            })
        }

    //add markup to first part of strings on gallery feature lines on homepage
        if($('#gallery li p').length){

            $('#gallery li p').each(function(){
                var originalText = $(this).html();
                var pieces = originalText.split(":");
                var newText = '<span class="label">'+pieces[0]+':</span>'+pieces[1];
                $(this).html(newText);
            });
        }

        
        var page_url = window.location.pathname;
     
            $(".alphalist a").each(function () {
                if ($(this).attr("href") == page_url) {
                    $(this).attr("href", "#");
                    $(this).addClass("active");
                }
                
            });
         //function mark_current_page_link_in_directory() {
         //    var page_url = window.location.pathname;
         //    $(".result a").each(function () {
         //        if ($(this).attr("href") == page_url) {
         //            $(this).attr("href", "#");
         //            $(this).parent().addClass("active");
         //        }
         //    });
         //
         //    var path = page_url.split("/");
         //    if (path[1] == 'publication') {
         //        $("#sidebar .subnav a").each(function () {
         //            if ($(this).attr('href') == '/phd-publications') {
         //                $(this).addClass('active');
         //            }
         //        });
         //    }
         //}
         //
         
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

             try {
                 $("a[rel]").overlay({
                     // some mask tweaks suitable for modal dialogs
                     mask: {
                         color: '#666666',
                         loadSpeed: 200,
                         opacity: 0.9
                     }
                 });
             } catch (err) {
             }
         }
     });


     $(window).resize(function () {
         Menu.initialize();

     });
 })(jQuery);
