<?php
$salaId = $salaInfo->salaId;
$locacion = $salaInfo->locacion;
$hora = $salaInfo->hora;
$cupos = $salaInfo->cupos;
$fecha = $salaInfo->fecha;
$valor = $salaInfo->valor;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Sala Management
        <small>Add / Edit Sala</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Sala Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editSala" method="post" id="editSala" role="form">
                        <input hidden type="number" name="salaId" value="<?php echo $salaId?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="locacion">Cancha</label>
                                            <select class="form-control" id="locacion" name="locacion" value="<?php echo $locacion; ?>">
                                            <?php 
                                            foreach($canchas as $cancha)
                                            { 
                                              echo '<option value="'.$cancha->nombre.'">'.$cancha->nombre.'</option>';
                                            }
                                            ?>
                                            </select>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cupos">Cupos</label>
                                        <input type="text" class="form-control required" id="cupos" value="<?php echo $cupos; ?>" name="cupos" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Fecha</label>
                                        <div class="form-group">
                                            <div class='input-group date' id='datetimepicker3'>
                                                <input type='text' class="form-control required" id="fecha" value="<?php echo $fecha; ?>" name="fecha" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#datetimepicker3').datetimepicker({
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valor">Valor</label>
                                        <input type="text" class="form-control required" id="valor" value="<?php echo $valor; ?>" name="valor" maxlength="128">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                 
                    $success = $this->session->flashdata('sala_updated');
                    if($success)
                    {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('sala_updated'); ?>
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

<script src="<?php echo base_url(); ?>assets/js/editSala.js" type="text/javascript"></script>