<?php
$nombre = $canchaInfo->nombre;
$direccion = $canchaInfo->direccion;
$telefono = $canchaInfo->telefono;
$localidad = $canchaInfo->localidad;
$imagen = $canchaInfo->imagen;
$canchaId = $canchaInfo->id;

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Cancha Management
        <small>Add / Edit Cancha</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Cancha Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <?php echo form_open_multipart('cancha/editCancha');?>
                         <input type="hidden" id="canchaId" name="canchaId" value="<?php echo $canchaId; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control required" id="nombre" value="<?php echo $nombre; ?>" name="nombre" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cupos">Direccion</label>
                                        <input type="text" class="form-control required" id="direccion" value="<?php echo $direccion; ?>" name="direccion" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono</label>
                                        <input type="text" class="form-control required" id="telefono" value="<?php echo $telefono; ?>" name="telefono" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="localidad">Localidad</label>
                                        <input type="text" class="form-control required" id="localidad" value="<?php echo $localidad; ?>" name="localidad" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="imagen">Imagen</label>
                                        <input type='file' class="form-control required" id="imagen" name="imagen"  />
                                    </div>
                                </div>  
                            </div>
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form'); 
                    $success = $this->session->flashdata('cancha_updated');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('cancha_updated'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editCancha.js" type="text/javascript"></script>