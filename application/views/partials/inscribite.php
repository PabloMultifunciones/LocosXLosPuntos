<?php
if (!isset($_SESSION["id"]) || $inscribed){
?>

<div class="modal fade" id="inscribete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog p-3" role="document" style="background-image: url('<?php echo base_url().'assets/imgs/inscribete.jpg';?>');">
    <div class="modal-content bg-transparent border-0">

        <div class="row">
            <div class="col col-6">
            <img class="img-thumbnail border-0 p-0"style="width:110px;" src="<?php echo base_url()."assets/imgs/Logo2.jpg";?>">

            </div>
            <div class="col col-6">
                <button type="button" id="closeSuscribite" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="col col-12">
                <h2 style="color:#005e44;background-color:white;"><l><em>UN TORNEO DISTINTO ESTÁ LLEGANDO</em><l></h2>
            </div>
            <div class="col col-12 mb-4">
                <h2 style="color:white;background-color:#005e44;">¿QUERES SER UNO DE LOS PRIMEROS EN JUGAR?</h2>
            </div>
            <div class="col col-12 mt-4">
                <h4 style="color:white;background-color:#005e44;">¡DATE DE ALTA EN LA WEB Y GENERA TU N° DE SOCIO!</h4>
            </div>
            <div class="col col-12">
                <h4 style="color:#005e44;background-color:white;">AL COMPLETAR ESTOS DATOS SERÁS INVITADO AL PRIMER ENCUENTRO DE LXP</h4>
            </div>
            <div class="modal-content bg-transparent p-2">
                <?php $fattr = array('class' => 'form-signin');
                echo form_open(base_url(), $fattr); ?>
                <div class="row">

                    <div class="col col-6">
                        <?php echo form_input(array(
                            'name'=>'nombreyapellido', 
                            'id'=> 'nombreyapellido', 
                            'placeholder'=>'Nombre y Apellido', 
                            'class'=>'form-control mb-2', 
                            'value'=> set_value('nombreyapellido')));
                        ?>
                    </div>
                    <div class="col col-12">
                        <?php echo form_error('nombreyapellido') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-6">
                        <?php echo form_input(array(
                            'name'=>'whatsapp', 
                            'id'=> 'whatsapp', 
                            'placeholder'=>'Whatsapp', 
                            'class'=>'form-control mb-2', 
                            'value'=> set_value('whatsapp'))); 
                        ?>
                    </div>
                    <div class="col col-12 text-danger">
                        <?php echo form_error('whatsapp') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-6">
                        <?php echo form_input(array(
                            'name'=>'email', 
                            'id'=> 'email', 
                            'placeholder'=>'Email', 
                            'class'=>'form-control mb-2', 
                            'value'=> set_value('email'))); 
                        ?>
                    </div>
                    <div class="col col-12 text-danger">
                        <?php echo form_error('email') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-6 ms-2">
                        <?php echo form_input(array(
                            'name'=>'localidad', 
                            'id'=> 'localidad', 
                            'placeholder'=>'Localidad', 
                            'class'=>'form-control', 
                            'value'=> set_value('localidad'))); 
                        ?>
                        <?php echo form_error('localidad') ?>
                    </div>
                    <div class="col col-5 offset-1">   
                        <?php echo form_submit(array('value'=>'Enviar',
                            'class'=>'btn btn-lg btn-success btn-block p-0'));
                        ?>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
  </div>
</div>

<input hidden type="button" id="triggerInscribete" class="btn btn-primary" data-toggle="modal" data-target="#inscribete" value="hola">
<?php
}
?>

<script>
$('document').ready(()=>{
  $('#triggerInscribete').trigger('click');
});
</script>