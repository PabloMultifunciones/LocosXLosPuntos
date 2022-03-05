<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$cupos = $sala->cupos - $sala->inscriptos;
$inscriptos = $sala->inscriptos;
?><!DOCTYPE html>
<html lang="en">
<div class="container-fluid">
	<div class="section-container">
	<div class="row">
		<div class="col-sm-12">
			<div class="sala-info">
				<h2>Sala:<?= $sala->salaId ." ";?> <?php echo $sala->locacion;?></h2>
				<h3>Hora: <?php  echo $sala->hora;?></h3>
			</div>

	<div class="instrucciones-block">
			<div class="instrucciones">
		SELECCiONA Si SOS O PODRiAS SER ARQUERO (A) LUEGO APRETA <button type="" class="btn btn-success">INSCRIBIRME</button>
		PODRAS INSCRIBIR A UN PARTICIPANTE EN iNSCRIBIR A UN AMIGO
	</div>
	<div class="promotor">INSCRIBIENDO A MAS DE 1 PARTiCiPANTE, TE CONVERTIS EN PROMOTOR.<br> SUMAS PUNTOS POR CADA PERSONA QUE INSCRIBAS.<br>
RECORDA QUE SOS EL RESPONSABLE Si TU INVITADO NO ASiSTE AL PARTiDO.</div>
	</div>
	</div>

	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="jugadores">Jugadores del partido</div>
			<div class="lugares-container">

			<?php 

			foreach ($jugadores as $jugador){
echo '<div class="col-sm-6 lugar">
						<button type="button" class="btn btn-danger">'.$jugador->first_name." ".$jugador->last_name." "."- EQUIPO ".$jugador->equipo.'</button>
					</div>';
			}

			?>

		
			<?php 
			for ($i = 1; $i <= $cupos; $i++) {
				echo '<div class="col-sm-6 lugar">
				<form role="form" action="'?><?php echo base_url() ?><?php echo'inscripcion" method="post" role="form">
								<div class="form-check" >
					<input type="checkbox" class="form-check-input" name="arquero">
					<label class="form-check-label" for="arquero">A</label>
				</div>
				<div class="dropdown col-sm-3" >

					<select class="custom-select" name="equipo">
					<option selected value="1">EQUIPO UNO</option>
					<option value="2">EQUIPO DOS</option>
					</select>
				</div>
				<button type="submit" class="btn btn-success">INSCRIBIRME</button>
				<input type="hidden" name="sala" value="'.$sala->salaId.'"/>
				</form>
				</div>';
			}
			;?>
		</div>
		</div>
	</div>
	<?php if ($this->session->flashdata('LOG IN')) { ?>
<div role="alert" class="alert alert-success">
   <button data-dismiss="alert" class="close" type="button">
	   <span aria-hidden="true">x</span><span class="only">Close</span></button>
   <?= $this->session->flashdata('LOG IN') ?>
</div>
<?php } ?>
	<?php if ($this->session->flashdata('GRACIAS')) { ?>
<div role="alert" class="alert alert-success">
   <button data-dismiss="alert" class="close" type="button">
	   <span aria-hidden="true">x</span><span class="only">Close</span></button>
   <?= $this->session->flashdata('GRACIAS') ?>
</div>
<?php } ?>
</div>
</div>

<div id="footer">
	<?php $this->load->view('partials/footer'); ?>
</div>
</body>
</html>