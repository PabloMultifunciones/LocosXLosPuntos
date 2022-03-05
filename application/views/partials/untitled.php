<div class="container-fluid navContainer">
	<div class="row align-self-end">

		<nav class="navbar navbar-expand-lg navbar-light">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Ingresar <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Mis partidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">¿Qué es LXP?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">Tu opinión nos interesa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">Preguntas frecuentes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">Reglamento</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">Puntos</a>
          </li>

        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="container-fluid">
 <div class="row justify-content-end">
  <div class="col-sm-7 slogan">
    <h1>Un torneo distinto</h1>
  </div>
</div>
</div>

<div class="banner container-fluid">
 <div class="row">
  <div class="col-sm-6">
   <a class="navbar-brand" href="<?php echo base_url(); ?>">
     <img class="logo-brand" src="<?php echo base_url('assets/imgs/Logo.png'); ?>"alt="" loading="lazy">
   </a>
 </div>


 <div class="col-sm-6 actions justify-content-end">
  <?php 
  if(null !== $this->session->userdata("id")){
    echo '<button type="button" class="btn btn-success">Mi perfil</button>';
  } else {
    echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" >INGRESAR</button>' ;
  }
  ?>
</div>
</div>

<?php echo $this->session->flashdata('flash_message');
?>
</div>

<?php $this->load->view('login'); 
?>
