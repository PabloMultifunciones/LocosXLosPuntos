

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingresar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $fattr = array('class' => 'form-signin');
         echo form_open(base_url().'landing/login', $fattr); ?>
    <div class="form-group">
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'value'=> set_value('email'))); ?>
      <?php echo form_error('email') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array(
          'name'=>'password', 
          'id'=> 'password', 
          'placeholder'=>'Password', 
          'class'=>'form-control', 
          'value'=> set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>
    <?php echo form_submit(array('value'=>'Ingresar', 'class'=>'btn btn-lg btn-success btn-block')); ?>
    <?php echo form_close(); ?>
      <p>¿No tenes una cuenta? Clickea acá para<a href="<?php echo site_url();?>landing/register">Registrarse</a></p>
      <p>Click <button id="buttonForgot" class="btn btn-link">acá</button> si olvidaste tu contraseña</p>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recuperar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $fattr = array('class' => 'form-signin');
         echo form_open(base_url().'landing/forgot', $fattr); ?>
    <div class="form-group">
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'value'=> set_value('email'))); ?>
      <?php echo form_error('email') ?>
    </div>
    <?php echo form_submit(array('value'=>'Enviar Correo', 'class'=>'btn btn-lg btn-success btn-block')); ?>
    <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<input hidden type="button" id="activateForgotModal" class="btn btn-success p-0 m-0" data-toggle="modal" data-target="#forgotModal" value="ingresar"/>


<script>
$('#buttonForgot').click(function (){
  $('.close').trigger('click');
  $('#activateForgotModal').trigger('click');
});
</script>
