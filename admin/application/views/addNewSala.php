<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Gestion de salas
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
            <?php $this->load->helper("form"); ?>
            <form role="form" id="addUser" action="<?php echo base_url() ?>addSala" method="post" role="form">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">                                
                            <div class="form-group">
                                <label for="locacion">Cancha</label>
                                <select class="form-control" id="locacion" name="locacion">
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
                            <input type="text" class="form-control required" id="cupos" value="<?php echo set_value('cupos'); ?>" name="cupos" maxlength="128">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Fecha</label>
                                   <div class="form-group">
                                      <div class='input-group date' id='datetimepicker3'>
                                         <input type='text' class="form-control required" id="fecha" value="<?php echo set_value('fecha'); ?>" name="fecha" />
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
                            <input type="text" class="form-control required" id="valor" value="<?php echo set_value('valor'); ?>" name="valor" maxlength="128">
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
    $error = $this->session->flashdata('error');
    /*if($error)
    {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error'); ?>                    
        </div>
    <?php } */?>
    <?php  
    $success = $this->session->flashdata('sala_success');
    if($success)
    {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('sala_success'); ?>
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
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>