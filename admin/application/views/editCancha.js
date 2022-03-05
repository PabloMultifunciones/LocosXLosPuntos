/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		
		rules:{
			locacion :{ required : true },
			cancha : { required : true, digits : true },
			hora : { required : true, digits : true }
		},
		messages:{
			locacion :{ required : "This field is required" },
			cancha : { required : "This field is required", digits : "Por favor ingrese un numero valido"},
			hora : { required : "This field is required", digits : "Por favor ingrese un numero valido"}	
		}
	});

});