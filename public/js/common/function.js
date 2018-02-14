function chosenInit(option = "Select a option", width = '100%', deselect = true, class_name = "chosen-select") {
	$('.'+class_name).chosen({
		allow_single_deselect: deselect,
		placeholder_text_single: option,
		no_results_text: "Oops, nothing found!",
		width: width
	});
}