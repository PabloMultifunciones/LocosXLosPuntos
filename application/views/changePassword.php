<div class="container">
	<?php
	if($this->session->flashdata('authenticated'))
	{
		if($state == "inProgress" || $state == "failed")
		{
	?>
			<div class="row">
				<div class="col col-12">
				<form method="post" action="<?php echo base_url() ?>landing/changePassword">
					<input hidden type="text" name="email" value="<?php echo $this->session->flashdata('email');?>">
					<div class="row mt-3">
						<div class="col col-5 text-right">
							<label for="password">Contraseña</label>
						</div>
						<div class="col col-4">
							<input class="form-control" id="password" type="password" name="password" value="">
						</div>
					</div>
					<div class="row mt-3">
						<div class="col col-5 text-right">
							<label for="confirmPassword">Confirmar Contraseña</label>
						</div>
						<div class="col col-4">
							<input class="form-control" id="confirmPassword" type="password" name="confirmPassword" value="">
						</div>					
					</div>
						<div class="col col-12 text-center">
							<button class="btn btn-success mt-3" type="submit">Confirmar</button>
						</div>
					
				</form>
				<?php
				if($state == "failed"){
				?>
					<div class="alert alert-danger mt-2" role="alert">
						<h3>La contraseña ingresada no es valida.</h3>
						<h4>Revise que:</h4>
						<h4>*Tenga almenos 5 caracteres</h4>
						<h4>*Las dos contraseñas sean iguales</h4>
					</div>
				<?php	
				}
				?>
				</div>
			</div>
	<?php
		}else if($state == "success"){
			$this->session->set_flashdata('authenticated',false);
		?>
			<div class="alert alert-success mt-2" role="alert">
				<h3>Su contraseña ha sido cambiada.</h3>
			</div>
		<?php
		}
	}else{
	?>
	<div class="alert alert-danger mt-2" role="alert">
		<h3>Para acceder a esta pagina debe acreditar un codigo de recuperacion.</h3>
	</div>
	<?php
	}
	?>
</div>
