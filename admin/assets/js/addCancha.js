/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#addUser");
	
	var validator = addUserForm.validate({
		
		rules:{
			nombre :{ required : true },
			direccion :{ required : true },
			localidad : { required : true }
		},
		messages:{
			nombre :{ required : "This field is required" },
			direccion :{ required : "This field is required" },
			localidad :{ required : "This field is required" }			
		}
	});
});
