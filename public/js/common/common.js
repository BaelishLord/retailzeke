$(document).ready(function() {
	$("#validateForm").validate({
		rules: {
			required: "required",
			// lastname: "required",
			number: {
				required: true,
				number: true
			}
			// password: {
			// 	required: true,
			// 	minlength: 5
			// },
			// confirm_password: {
			// 	required: true,
			// 	minlength: 5,
			// 	equalTo: "#password"
			// },
			// email: {
			// 	required: true,
			// 	email: true
			// },
			// topic: {
			// 	required: "#newsletter:checked",
			// 	minlength: 2
			// },
			// agree: "required"
		},
		messages: {
			required: "This field is requied.",
			number: {
				required: "This field is requied.",
				number: "Please enter only numeric value."
			}
			// password: {
			// 	required: "Please provide a password",
			// 	minlength: "Your password must be at least 5 characters long"
			// },
			// confirm_password: {
			// 	required: "Please provide a password",
			// 	minlength: "Your password must be at least 5 characters long",
			// 	equalTo: "Please enter the same password as above"
			// },
			// email: "Please enter a valid email address",
			// agree: "Please accept our policy",
			// topic: "Please select at least 2 topics"
		}
	});
})