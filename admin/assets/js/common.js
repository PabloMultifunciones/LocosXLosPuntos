/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation){
			console.log(hitURL);
		}
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteInscripcion", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteInscripcion",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation){
			console.log(hitURL);
		}
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteSala", function(){
		var salaId = $(this).data("userid"),
			hitURL = baseURL + "deleteSala",
			currentRow = $(this);
			console.log(salaId);
		var confirmation = confirm("Esta seguro que quiere borrar esta sala?");

		if(confirmation){
			console.log(hitURL);
		}
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { salaId : salaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Sala successfully deleted"); }
				else if(data.status = false) { alert("Sala deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteCancha", function(){
		var canchaId = $(this).data("userid"),
			hitURL = baseURL + "deleteCancha",
			currentRow = $(this);
			console.log(canchaId);
		var confirmation = confirm("Esta seguro que quiere borrar esta cancha?");

		if(confirmation){
			console.log(hitURL);
		}
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { canchaId : canchaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Cancha successfully deleted"); }
				else if(data.status = false) { alert("Cancha deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deletePlayer", function(){
		var canchaId = $(this).data("userid"),
			hitURL = baseURL + "deletePlayer",
			currentRow = $(this);
			console.log(canchaId);
		var confirmation = confirm("Esta seguro que quiere borrar este jugador?");

		if(confirmation){
			console.log(hitURL);
		}
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : canchaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Player successfully deleted"); }
				else if(data.status = false) { alert("Player deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
