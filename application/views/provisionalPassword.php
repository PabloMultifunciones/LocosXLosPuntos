<div class="container">
	<?php
	if($existEmail){
	?>
	<div class="alert alert-success mt-2" role="alert">
		<h3>Se ha enviado un correo de recuperación. Este proceso puede tardar algunos minutos. En caso de no encontrarlo <strong class="text-danger">revisar la sección "Correo no deseado"(spam)</strong>.</h3>
	</div>

	<form method="POST" action="<?php echo base_url()?>landing/forgot">
		<div class="row">
			<div class="col col-6 offset-3 input-group mb-3">
				<input type="text" class="form-control" name="provisionalPassword" placeholder="Codigo" aria-label="Recipient's username" aria-describedby="button-addon2">
				<button class="btn btn-outline-success" type="submit" id="button-addon2">Confirmar</button>
			</div>
		</div>
	</form>
	<?php
		if(isset($esIgual)){
			?>
				<h1>El codigo no es correcto</h1>
			<?php
		}
	}else{
	?>
	<div class="alert alert-danger mt-2" role="alert">
		<h3>El correo electronico no existe.</h3>
	</div>
	<?php
	}
	?>
</div>
