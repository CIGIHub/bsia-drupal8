 var mobileBp = 940;

 (function ($) {
     $(document).ready(function () {
         //Menu.initialize();

        if($('#search-block-form').length){
            var searchFormInput = $('#search-block-form input');
            searchFormInput.focus(function(){
                if (searchFormInput.val() == 'Search') {
                    searchFormInput.val("");
                }
            }).blur(function(){
                if (searchFormInput.val() == '') {
                    searchFormInput.val('Search');
                }
            });

        }

        //add markup to first part of strings on gallery feature lines
        if($('#gallery li p').length){

            $('#gallery li p').each(function(){
                var originalText = $(this).html();
                var pieces = originalText.split(":");
                var newText = '<span class="label">'+pieces[0]+':</span>'+pieces[1];
                $(this).html(newText);
            });
        }

         //function search_clear_button(event) {
         //    event.cancelBubble = true;
         //    event.stopPropagation();
         //    event.preventDefault();
         //
         //    $("#widget-edit-keys input").val("");
         //    toggle_clear_button(event);
         //
         //    current_base_page = window.location.href.split('?')[0];
         //
         //    if (current_base_page.match(/search$/)) {
         //        window.location.href = current_base_page.slice(0, -6);
         //    }
         //
         //}
         //
         //function toggle_clear_button(event) {
         //    if ($("#widget-edit-keys input").val() == "") {
         //        $("#clear_button").hide();
         //    } else {
         //        $("#clear_button").show();
         //    }
         //}

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
         //$("#clear_button").click(search_clear_button);
         //$("#widget-edit-keys").bind("keyup keydown change", toggle_clear_button);
         //$("#edit-keys").attr("placeholder", window.placeholder_text_for_search);
         //toggle_clear_button();
         //mark_current_page_link_in_directory();
         //
         //Calendar drop down
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
