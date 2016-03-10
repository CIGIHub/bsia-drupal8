$(document).ready(function () {

	$("#edit-tid option").eq(0).text("Filter by Topic");
	$("#edit-tid").removeClass('form-select').addClass('chosen-select');

	//calls the chosen function
	$(".chosen-select").chosen()
	//$(".chzn-select-deselect").chosen({allow_single_deselect:true});

});