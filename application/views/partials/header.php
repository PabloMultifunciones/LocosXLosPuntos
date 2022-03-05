<?php 

$seshId = "";

if (isset($_SESSION["id"])){
  $seshId = "/".$_SESSION["id"];
}

?>

<div class="container-fluid navContainer">
	<div class="row align-self-end">

		<nav class="navbar navbar-expand-lg navbar-light">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <?php
          if(!isset($_SESSION['id']))
          {
          ?>

            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url(). "/login" ?>" data-toggle="modal" data-target="#exampleModal" >Ingresar <span class="sr-only">(current)</span></a>
            </li>

          <?php
          }else 
          {
          ?>

            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url(). "/logout" ?>">Cerrar Sesion <span class="sr-only">(current)</span></a>
            </li>

          <?php
          }
          ?>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url("/misPartidos".$seshId); ?>">Mis partidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url("/queEs"); ?>">¿Qué es LXP?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="<?php echo base_url("/contact"); ?>">Tu opinión nos interesa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url("/puntos"); ?>">Puntos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="<?php echo base_url("/assets/reglamento.pdf"); ?>">Reglamento</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="container-fluid">
 <div class="row justify-content-end">
  <div class="col-9 slogan">
    <h1>Un torneo distinto</h1>
  </div>
</div>
</div>

<div class="banner container-fluid">
 <div class="row">
  <div class="col-5">
   <a class="navbar-brand" href="<?php echo base_url(); ?>">
     <img class="logo-brand" src="<?php echo base_url('assets/imgs/Logo.png'); ?>"alt="" loading="lazy">
   </a>
 </div>


 <div class="col-7 actions justify-content-end">
  <?php 
  if(null !== $this->session->userdata("id")){
    echo '<a href="' .base_url("/misPartidos/".$seshId).'" ><button type="button" class="btn btn-success">¡Hola '.$this->session->userdata("first_name").'ǃ<br>
    <span class="puntos">Puntos: '.$this->session->userdata("puntos").'</span></button></a>';
  } else {
    echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" >INGRESAR</button>' ;
  }
  ?>
</div>
</div>

<?php echo $this->session->flashdata('flash_message'); unset($_SESSION['flash_message']); 
?>
</div>

<?php $this->load->view('login'); ?>
