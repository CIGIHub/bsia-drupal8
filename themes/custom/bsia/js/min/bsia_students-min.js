$(document).ready(function(){function t(t){t.cancelBubble=!0,t.stopPropagation(),t.preventDefault();var n=this,d=$(n).parent().attr("data-row-id"),i="#"+$(n).attr("id"),a=$("#description-"+d),c=$(i).hasClass("selected-student");if($(".selected-student").length>0){var l=$(".selected-student").parent().attr("data-row-id"),r=$("#description-"+l);s(r),c||e(i,a)}else e(i,a)}function e(t,e){var s=$(t+" .student-description").html();e.empty(),$("[id^='student-']").addClass("unselected-student"),$(t).addClass("selected-student"),$(t).removeClass("unselected-student");var i=n(t);e.append(i);var a=d(e);e.append(a),e.append($(s)).slideDown(800)}function s(){$("[id^='description-']").hide();var t=$("[id^='student-']");t.removeClass("unselected-student"),t.removeClass("selected-student")}function n(t){var e=$("<div class='uparrowdiv'></div>"),s=$(t).offset().left-$(".view-content").offset().left+35;return s>9900&&(s-=1e4),s+="px",e.css({left:s}),e}function d(t){var e=$('<div class="close"><i class="fa fa-times-circle"></i></div>');return e.click(function(e){e.cancelBubble=!0,e.stopPropagation(),e.preventDefault(),s(t)}),e}function i(){var t=0;$("ul.student-list").each(function(){var e=$(this).children("li"),s=e.length;e.each(function(e){$(this).attr("data-row-id","row-"+t),((e+1)%6===0||e===s-1)&&($(this).after("<hr><div class='student-description' id='description-row-"+t+"'></div>"),t+=1)})})}function a(){$(".students-all-programs h3").length>0&&$(' <i class="fa fa-list-ul"></i>').appendTo(".students-all-programs h3 a")}$("#edit-tid option").eq(0).text("Filter by Topic"),$("#edit-tid").removeClass("form-select").addClass("chosen-select"),$(".chosen-select").chosen(),a(),i(),$("[id^='student-']").click(t)});