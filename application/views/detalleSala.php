<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$cupos = $sala->cupos - $sala->inscriptos;
$inscriptos = $sala->inscriptos;
?>

<!DOCTYPE html>
<html lang="en">
<div class="container-fluid sala">
	<div class="section-container">
		<div class="row">
			<div class="col-12">
				<div class="sala-info">
					<h2>Sala:<?= $sala->salaId ." ";?> <?php echo $sala->locacion;?></h2>
					<h3>Fecha: <?php  echo $sala->fecha;?></h3>
					<h3>Hora: <?php  echo $sala->hora;?></h3>
					<h3>Valor: $<?php  echo $sala->valor;?></h3>
				</div>

				<div class="instrucciones-block">
					<div class="instrucciones">
						SELECCiONA Si SOS O PODRiAS SER ARQUERO (A) LUEGO APRETA <button type="" class="btn btn-success">INSCRIBIRME</button>
						PODRAS INSCRIBIR A UN PARTICIPANTE EN <button type="" class="btn btn-success">iNSCRIBIR A UN AMIGO</button> PREVIO A FINALIZAR TU INSCRIPCION
					</div>
					<div class="promotor">INSCRIBIENDO A MAS DE 1 PARTiCiPANTE, TE CONVERTIS EN LIDER LXP.<br> SUMAS PUNTOS POR CADA PERSONA QUE INSCRIBAS.<br>
					RECORDA QUE SOS EL RESPONSABLE Si TU INVITADO NO ASiSTE AL PARTiDO.</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-12">
				<div class="jugadores">Jugadores del partido</div>
				<div class="lugares-container d-flex justify-content-end">
					<form role="form" action="<?php echo base_url().'inscripcion' ?>" method="post" role="form" class="tablainscripcion">
						<input type="hidden" name="sala" value="<?= $sala->salaId ?>"/>
						<?php 

						foreach ($jugadores as $jugador){

							echo '<div class="col-6 lugar">
							<div class="btn btn-danger">'.(($jugador->amigo == 1) ? "<span class='small'>amigo</span>" :"")." ".$jugador->last_name." "."- EQUIPO ".$jugador->equipo.'</div>
							</div>';
						}

						?>

						<?php 
						for ($i = 1; $i <= $cupos; $i++) {
							echo '<div class="col-6 lugar form-group">
											<div class="form-check arquero" >
							<input type="checkbox" class="form-check-input" name="jugador['.$i.'][arquero]">
							<label class="form-check-label" for="jugador['.$i.'][arquero]">A</label>
							</div>

							<label class="inscriptlabel '.(($i == 1) ? "" : "amigo").'" for="jugador['.$i.'][inscripto]">
							<input class="form-check-input" type="checkbox" name="jugador['.$i.'][inscripto]" value="1"><span>'.(($i == 1) ? "INSCRIBIRME" : "INSCRIBIR A UN AMIGO").'</span>
							</label>

			
							<div class="dropdown" >

							<label class="form-check-label" for="jugador['.$i.'][equipo]">Equipo</label>
							<select class="custom-select" name="jugador['.$i.'][equipo]">
							<option selected value="1">1</option>
							<option value="2">2</option>
							</select>
							</div>


							</div>';
						}
						;?>
					<?php if(isset($inscripto)){
						echo "<a data-confirm='¿Estas seguro que quieres darte de baja a ti y a todos tus amigos de esta sala?' class='deBaja' href='".base_url('/deBaja/'.$sala->salaId)."' ><div class='btn btn-danger deBaja'>Darme de baja</div></a>";
					} else { ;?>


			
					<div class="pagos d-flex justify-content-end">
						<div class="col-5 form-check">
							<input class="form-check-input" type="radio" name="pago" id="pagoCancha" value="0" checked>
							<label class="form-check-label" for="pagoCancha">
								Pago en la cancha
							</label>
						</div>
						<div class="col-5 form-check">
							<input class="form-check-input" type="radio" name="pago" id="pagoMercadopago" value="1">
							<label class="form-check-label" for="pagoMercadopago">
								Pago con Mercado Pago
							</label>

						</div>
					</div>


					<button class="submitInscripcion" type="submit">Finalizar inscripcion</button>
				<?php  }; ?>
				</form>
			</div>
			</div>
		</div>
		<?php if ($this->session->flashdata('LOG IN')) { ?>
			<div role="alert" class="alert alert-danger">
				<button data-dismiss="alert" class="close" type="button">
					<span aria-hidden="true">x</span><span class="only">Close</span></button>
					<?= $this->session->flashdata('LOG IN') ?>
				</div>
				<?php unset($_SESSION['LOG IN']); ?>
			<?php } ?>
			<?php if ($this->session->flashdata('INSCRIBIR')) { ?>
			<div role="alert" class="alert alert-danger">
				<button data-dismiss="alert" class="close" type="button">
					<span aria-hidden="true">x</span><span class="only">Close</span></button>
					<?= $this->session->flashdata('INSCRIBIR') ?>
				</div>
				<?php unset($_SESSION['INSCRIBIR']); ?>
			<?php } ?>
			<?php if ($this->session->flashdata('SUSCRIPTO')) { ?>
				<div role="alert" class="alert alert-danger">
					<button data-dismiss="alert" class="close" type="button">
						<span aria-hidden="true">x</span><span class="only">Close</span></button>
					<?= $this->session->flashdata('SUSCRIPTO') ?>
				</div>
				<?php unset($_SESSION['SUSCRIPTO']); ?>
			<?php } ?>
				<?php if ($this->session->flashdata('CUPOS')) { ?>
			<div role="alert" class="alert alert-danger">
				<button data-dismiss="alert" class="close" type="button">
					<span aria-hidden="true">x</span><span class="only">Close</span></button>
					<?= $this->session->flashdata('CUPOS') ?>
				</div>
				<?php unset($_SESSION['CUPOS']); ?>
			<?php } ?>
			<?php if ($this->session->flashdata('NO INSCRIPTO')) { ?>
			<div role="alert" class="alert alert-danger">
				<button data-dismiss="alert" class="close" type="button">
					<span aria-hidden="true">x</span><span class="only">Close</span></button>
					<?= $this->session->flashdata('NO INSCRIPTO') ?>
				</div>
				<?php unset($_SESSION['CUPOS']); ?>
			<?php } ?>
			<?php if ($this->session->flashdata('GRACIAS')) { ?>
				<div role="alert" class="alert alert-success">
					<button data-dismiss="alert" class="close" type="button">
						<span aria-hidden="true">x</span><span class="only">Close</span></button>
						<?= $this->session->flashdata('GRACIAS') ?>
						<?php unset($_SESSION['GRACIAS']); ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div id="footer">
			<?php $this->load->view('partials/footer'); ?>
		</div>
	</body>
	</html>
	<script type="text/javascript">
		$(document).ready(function () {
	    $(".arquero").on('click', function () {  //  here $(this) is refering to document

	    	if($(this).hasClass('checkeao')) {
	    		$(this).removeClass("checkeao");
	    		$( this ).find( "input" ).prop( "checked", false );
	    	} else{
	    		$(this).addClass("checkeao");
	    		$( this ).find( "input" ).prop( "checked", true );
	    	}
	    	return false;
	    });

	    $(".inscriptlabel").on('click', function () {  //  here $(this) is refering to document

	    	if($(this).hasClass('checkeao')) {
	    		$(this).removeClass("checkeao");
	    		$( this ).find( "input" ).prop( "checked", false );

	    	} else{
	    		$(this).addClass("checkeao");
	    		console.log("checkeao");
	    		$( this ).find( "input" ).prop( "checked", true );
	    	}
	    	return false;
	    });

	    $("[data-labelfor]").click(function() {
	    	$('#' + $(this).attr("data-labelfor")).prop('checked',
	    		function(i, oldVal) { return !oldVal; });
	    });
	});

		$('label').click(function() {
			labelID = $(this).attr('for');
			$('#'+labelID).trigger('click');
		});

		$('a.debaja').click(function() {
			var debaja = confirm("Estas seguro que quieres darte de baja a ti y a todos tus amigos inscriptos?");
			if (debaja == false){
				event.preventDefault();
			}
		});

	</script>