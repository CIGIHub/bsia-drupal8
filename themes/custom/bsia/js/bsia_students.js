
$(document).ready(function(){

    function photo_click_handler(event){
        event.cancelBubble = true;
        event.stopPropagation();
        event.preventDefault();

        var selectedStudent = this;
        var studentRow = ($(selectedStudent).parent().attr('data-row-id'));
        var studentId = '#' + $(selectedStudent).attr("id");
        var descriptionRow = $("#description-" + studentRow);
        var isCurrentlySelected = $(studentId).hasClass('selected-student');

        if($('.selected-student').length > 0){

            var activeStudentRowId =  $(".selected-student").parent().attr("data-row-id");
            //var activeStudentId = '#' + $(".selected-student").attr("id");
            var activeDescriptionRow =  $("#description-" + activeStudentRowId);

            clear_selection(activeDescriptionRow);
            
            if(!isCurrentlySelected){
                select_student(studentId, descriptionRow);
            }
        }
        else{
            select_student(studentId, descriptionRow);
        }
    }

    function select_student(studentId, descriptionRow){

        var studentDescription = $(studentId + ' .student-description').html();
        
        descriptionRow.empty();

        $("[id^='student-']").addClass('unselected-student');
        $(studentId).addClass('selected-student');
        $(studentId).removeClass('unselected-student');
        
        var arrowDiv = position_arrow(studentId);
        descriptionRow.append(arrowDiv);

        var closeDiv = close_button(descriptionRow);
        descriptionRow.append(closeDiv);

        descriptionRow.append($(studentDescription)).slideDown(800);
    }

    function clear_selection(){
        $("[id^='description-']").hide();
        var all_photos = $("[id^='student-']");
        all_photos.removeClass('unselected-student');
        all_photos.removeClass('selected-student');
    }

    function position_arrow(studentId){
        var arrowDiv = $("<div class='uparrowdiv'></div>");
        var left = $(studentId).offset().left - $('.view-content').offset().left + 50;
        
        if (left > 9900){
            left -= 10000;
        }
        left += 'px';

        arrowDiv.css({
            'left':  left,
        });

        return arrowDiv;
    }

    function close_button(descriptionToClose){
        var closeDiv = $('<div class="close"><i class="fa fa-times-circle"></i></div>');

        closeDiv.click(function(event){
            event.cancelBubble = true;
            event.stopPropagation();
            event.preventDefault();

            clear_selection(descriptionToClose);
        });
        return closeDiv;
    }

    function insert_description_ids(){
        
        var row_id = 0;
        $("ul.student-list").each(function(){
            var items = $(this).children("li");
            var total = items.length;
            items.each(function(item_index){
                $(this).attr('data-row-id', 'row-'+row_id);
                if ((item_index + 1) % 6 ===  0 || item_index === total - 1){
                    $(this).after("<hr><div class='student-description' id='description-row-" + row_id + "'></div>");
                    row_id += 1;
                }
            });
        });
    }

    function insert_icon(){

        if($('.students-all-programs h3').length > 0){
           $(' <i class="fa fa-list-ul"></i>').appendTo('.students-all-programs h3 a');
        }
        
    }

    //attach chosen dropdown plugin to student topic filter
    $("#edit-tid option").eq(0).text("Filter by Topic");
    $("#edit-tid").removeClass('form-select').addClass('chosen-select');
    $(".chosen-select").chosen();

    insert_icon();
    insert_description_ids();
    $("[id^='student-']").click(photo_click_handler);

});
