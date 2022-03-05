<?php

function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.' '.$num.' de '.$mes.' del '.$anno;
}
 
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}
?>

<div class="container-fluid">

	<div class="row proximos"><h2>PRÓXIMOS ENCUENTROS</h2>
        <div class="col-6">
            <form role="form" action="<?php echo base_url() ?>salaListingFiltered" method="post" id="filtroZona" role="form">                                
            <div class="form-group">
                <select class="form-control filtro" id="jugador" name="jugador" onchange="this.form.submit()">
                    <option value="">Filtra por zona</option>
                    <?php 
                    $salas = array();
                    foreach ($filterRecords as $sala) {
                        $salas[] = $sala->localidad;
                    }
                    $unique_data = array_unique($salas);
                    // now use foreach loop on unique data
                    foreach($unique_data as $sala) {
                           echo '<option value="'.$sala.'">'.$sala.'</option>';
                    }
                  ?>
              </select>
          </div>
      </form>
        </div>
        
      <div class="col-6">
            <form role="form" action="<?php echo base_url() ?>salaListingFiltered" method="post" id="filtroPartidos" role="form">                                
            <div class="form-group">
                <select class="form-control filtro" id="jugador" name="jugador" onchange="this.form.submit()">
                    <option value="">Filtra por tipo de cancha</option>
                    <?php 
                    $salas = array();
                    foreach ($filterRecords as $sala) {
                        $salas[] = $sala->cupos;
                    }
                    $unique_data = array_unique($salas);
                    // now use foreach loop on unique data
                    foreach($unique_data as $sala) {
                           echo '<option value="'.$sala.'">Futbol '.($sala / 2 ).'</option>';
                    }
                  ?>
              </select>
          </div>
      </form>
        </div>
</div>
<div class="row">

    <div id="recipeCarousel" class="carousel slide w-100 mb-3" data-ride="carousel">
        <div class="carousel-inner w-100" role="listbox">
            <?php 
                foreach ($salaRecords as $sala) {
                $equipos = $sala->cupos / 2;
                $base_url = base_url();
                echo "
                <div class='carousel-item'>
                    <div class='col-4'>
                        <a href=". ($base_url)."sala/".($sala->salaId) ." class='stretched-link' ></a>

                        <div class='match-info'>
                            
                            <p class='card-header'>
                                
                                SALA ".$sala->salaId.":<br> <span class='barrio'>".$sala->localidad ."</span>
                            </p> 
                        </div>
                        
                        <div class='card card-body'>
                        
                            <img class='img cancha' src='".$base_url."assets/imgs/". ($sala->imagen) ."'>
                            
                            <h5 class='card-title'> $sala->locacion <br> $equipos VS $equipos </h5>

                        </div>
                
                        <div class='match-info-bottom'>
                
                            <p class='card-text'>". obtenerFechaEnLetra($sala->fecha) ."<br>Hora: $sala->hora </p>
                        
                            <!-- <p class='card-text'>".( $sala->cupos - $sala->inscriptos > 0 ? ($sala->cupos - $sala->inscriptos) ." cupos libres " :  ($sala->salaId) ." Sala completa / Inscribirme en lista de espera")."</p> -->
                            
                            <p class='card-text'>".( $sala->cupos - $sala->inscriptos > 0 ? ($sala->cupos - $sala->inscriptos) ." cupos libres " :  " Sala completa")."</p>
                        </div>

                    </div>

                </div>
                ";
            }
            ;?>
        </div>
        <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>	
</div>
<?php if ($this->session->flashdata('suscripto')) { ?>
      <div role="alert" class="alert alert-success">
        <button data-dismiss="alert" class="close" type="button">
          <span aria-hidden="true">x</span><span class="only">Close</span></button>
          <?= $this->session->flashdata('suscripto') ?>
        </div>
        <?php unset($_SESSION['suscripto']); ?>
      <?php } ?>
      <?php if ($this->session->flashdata('ingresa')) { ?>
      <div role="alert" class="alert alert-danger">
        <button data-dismiss="alert" class="close" type="button">
          <span aria-hidden="true">x</span><span class="only">Close</span></button>
          <?= $this->session->flashdata('ingresa') ?>
        </div>
        <?php unset($_SESSION['ingresa']); ?>
      <?php } ?>



<script type="text/javascript">
	$('#recipeCarousel').carousel({
      interval: 10000
  })

    $('.carousel .carousel-item').each(function(){
        var minPerSlide = 3;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i=0;i<minPerSlide;i++) {
            next=next.next();
            if (!next.length) {
               next = $(this).siblings(':first');
           }

           next.children(':first-child').clone().appendTo($(this));
       }
   });
    $( document ).ready(function() {
        $(".carousel-inner div:first").addClass("active");
    });

</script>