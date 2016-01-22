
    $(document).ready(function(){
        function photo_click_handler(event){
            event.cancelBubble = true;
            event.stopPropagation();
            event.preventDefault();

            var selected_photo = this;
            var row_id = $(selected_photo).parent().attr("data-row_id");
            var description_section = $("#description_section_" + row_id);
            var is_currently_selected = $(selected_photo).hasClass('selected_student');

            if ($(".selected_student").length > 0){
                var currently_selected_description_section_row = $(".selected_student").parent().attr("data-row_id");
                var currently_selected_description_section = $("#description_section_" + currently_selected_description_section_row);
                currently_selected_description_section.slideUp('slow', function(){
                    clear_student_selection(description_section);

                    if (!is_currently_selected){
                        select_student(description_section, selected_photo)
                    }
                });
            } else {
                select_student(description_section, selected_photo);
            }

        }

        function photo_hover_on_handler(event){
            $(this).addClass('hovered_student');

        }

        function photo_hover_off_handler(event){
            $(this).removeClass('hovered_student');

        }

        function select_student(description_section, student_to_select){
            description_section.empty();

            var nid = $(student_to_select).attr("data-nid");
            var arrow_div = create_arrow(student_to_select);
            description_section.append(arrow_div);

            var close_div = create_close(description_section);
            description_section.append(close_div);

            var next_description = $('#description_' + nid).html();
            description_section.append(next_description);

            description_section.slideDown(800);

            $("[id^='photo_']").addClass('unselected_student');
            $(student_to_select).addClass('selected_student');
            $(student_to_select).removeClass('unselected_student');
        }

        function clear_student_selection(description_section){
            $("[id^='description_']").hide();
            var all_photos = $("[id^='photo_']");
            all_photos.removeClass('unselected_student');
            all_photos.removeClass('selected_student');


        }

        function create_arrow(current_photo){
            var arrow_div = $("<div class='uparrowdiv'></div>");
            var left = $(current_photo).position().left - ($(current_photo).width() / 2) + 6;
            //console.log($(current_photo).width());
            if (left > 9900){
                left -= 10000;
            }
            left += 'px';

            arrow_div.css({
                'left':  left,
                'position': 'absolute'
            });

            return arrow_div;
        }

        function create_close(section_to_close){
            var close_div = $("<div class='close'> </div>");

            close_div.click(function(event){
                event.cancelBubble = true;
                event.stopPropagation();
                event.preventDefault();

                clear_student_selection(section_to_close);
            });
            return close_div;
        }

        function insert_description_areas(){
            var row_id = 0;
            $(".item-list.students_list ul").each(function(section_index){
                var item_list = $(this).children("li");
                var total = item_list.length;
                item_list.each(function(item_index){
                    $(this).attr('data-row_id', row_id);
                    if ((item_index + 1) % 6 == 0 || item_index === total - 1){
                        $(this).after("<div class='divider'></div><div class='student_text text' id='description_section_" + row_id + "'></div>");
                        row_id += 1;
                    }
                });
            });
        }


        insert_description_areas();
        $("[id^='description_']").hide();

        $("[id^='photo_']").click(photo_click_handler);
        $("[id^='photo_']").hover(photo_hover_on_handler, photo_hover_off_handler);
    });
