if (Drupal.jsEnabled) {
  $(document).ready(function () {

$("#edit-tid-1 option").eq(0).text("Filter by Topic");
$("#edit-tid-1").removeClass('form-select').addClass('chzn-select');

//calls the chosen function
$(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

	//end of function

	});
}