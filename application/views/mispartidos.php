<div class="container misPartidos">
	
	<div class="row">
<?php if(isset($_SESSION["id"])){ ?>		
		<div class="col-12 viejosPartidos">
			<h3>Mis partidos</h3><br>
		<div class="row">
			<?php 		
			foreach ($jugados as $inscripciones) {
				echo "<div class='col-4'><div class='btn btn-primary'>
				Sala: ".
				$inscripciones->salaId
				."<br>".$inscripciones->locacion ."
				<br>".$inscripciones->fecha ."
				<br>".$inscripciones->hora ."
				</div></div>";
			}

			?>
			</div>
		</div>
		
		<div class="col-12 proximosPartidos">
			<h3>Próximos partidos</h3><br>
			<div class="row">
			<?php 		
			foreach ($futuros as $inscripciones) {
				echo "<div class='col-4'><div class='btn btn-success'>
				Sala: ".
				$inscripciones->salaId
				."<br>".$inscripciones->locacion ."
				<br>".$inscripciones->fecha ."
				<br>".$inscripciones->hora ."
				</div></div>";
			}

			?>
			</div>
		</div>
		<?php  }else{  ?>
			<div class="col-12">
				<h3>Por favor ingresa para ver tus partidos</h3>
			</div>
		<?php  }; ?>
	</div>

</div>
