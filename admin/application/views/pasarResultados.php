<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Resultados de partido
        <small> <?php echo $salaInfo->salaId ." / ". $salaInfo->locacion ; ?></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->

          <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Detalles del partido</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>confirmResultados" method="post" id="confirmResultados" role="form">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">                                
                            <div class="form-group">
                                <label for="equipo1">Equipo 1</label>
                                <input type="number" class="form-control" id="equipo1" min="0" placeholder="Goles" name="equipo1" value="<?php echo set_value('equipo1'); ?>" maxlength="128">
                                <input type="hidden" value="<?php echo  $salaInfo->salaId; ?>" name="salaId" id="salaId" />    
                            </div>
                        </div>
                        <div class="col-md-6">                                
                            <div class="form-group">
                                <label for="last_name">Equipo 2</label>
                                <input type="number" class="form-control" id="equipo2" min="0" placeholder="Goles" name="equipo2" value="<?php echo set_value('equipo2'); ?>" maxlength="128">
                            </div>
                        </div>  
                    </div>                        
                    <div class="row">  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Fair Play</label>
                                <input type="checkbox" name="fairPlay[]" id="fairPlay" name="fairPlay" value="1">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Fair Play</label>
                                <input type="checkbox" name="fairPlay2[]" id="fairPlay2" name="fairPlay2" value="1">
                            </div>
                        </div>

                    </div>
                </div><!-- /.box-body -->
                <div class="box-body table-responsive no-padding">

                </div><!-- /.box-body -->

                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Submit" />
                    <input type="reset" class="btn btn-default" value="Reset" />
                </div>
            </form>
<div class="box-header">
                <h3 class="box-title">Ingresar puntos de jugador</h3>
            </div><!-- /.box-header -->

            <form role="form" action="<?php echo base_url() ?>confirmPuntosPlayer" method="post" id="confirmPuntosPlayer" role="form">
                <input type="hidden" value="<?php echo  $salaInfo->salaId; ?>" name="salaId" id="salaId" />   
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">                                
                            <div class="form-group">
                                <label for="equipo1">Jugador</label>
                                <select class="form-control" id="jugador" name="jugador">
                                    <?php 
                                    foreach($playerInfo as $player)
                                    { 
                                      echo '<option value="'.$player->idJugador.'">'.$player->first_name." ".$player->last_name.'</option>';
                                  };
                                  ?>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-2">                                
                            <div class="form-group">
                                <label for="penal">Penales convertidos</label>
                                <input type="number"  min="0" class="form-control" id="penal" placeholder="Penal convertido" name="penal" value="<?php echo set_value('penal'); ?>" maxlength="128">
                            </div>
                        </div>
                        <div class="col-md-2">                                
                            <div class="form-group">
                                <label for="atajados">Penales atajados</label>
                                <input type="number"  min="0" class="form-control" id="atajados" placeholder="Atajados" name="atajados" value="<?php echo set_value('atajados'); ?>" maxlength="128">
                            </div>
                        </div>
                        <div class="col-md-2">                                
                            <div class="form-group">
                                <label for="orden">Orden</label>
                                <select class="form-control" id="orden" name="orden">
                                    <option value="0">Orden</option>
                                    <option value="1">Tercero</option>
                                    <option value="2">Segundo</option>
                                    <option value="3">Primero</option>
                                </select>
                            </div>
                        </div>      
                    </div>                        
                    <div class="row">  
                        <div class="col-md-2">                                
                            <div class="form-group">
                                <label for="errado">Penales errados</label>
                                <input type="number" min="0" class="form-control" id="errado" placeholder="Penal errado" name="errado" value="<?php echo set_value('errado'); ?>" maxlength="128">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="promotor">Promotor</label>
                                <input type="number"  min="0" class="form-control" id="promotor" placeholder="Promotor" name="promotor" value="<?php echo set_value('promotor'); ?>" maxlength="128">
                            </div>
                        </div>

                       <div class="col-md-2">
                            <div class="form-group">
                                <label for="amarilla">Amarilla</label>
                                <input type="checkbox" name="amarilla" id="amarilla" name="amarilla" value="1">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="roja">Roja</label>
                                <input type="checkbox" name="roja" id="roja" name="roja" value="1">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inasistencia">Inasistencia</label>
                                <input type="checkbox" name="inasistencia" id="inasistencia" name="inasistencia" value="1">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inasistenciaAmigo">Inasistencia Amigo</label>
                                <input type="checkbox" name="inasistenciaAmigo" id="inasistenciaAmigo" name="inasistenciaAmigo" value="1">
                            </div>
                        </div>

                    </div>

                </div><!-- /.box-body -->
                <div class="box-body table-responsive no-padding">

                </div><!-- /.box-body -->

                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Submit" />
                    <input type="reset" class="btn btn-default" value="Reset" />
                </div>
            </form>
            <table class="table table-hover">
                <tr>
                    <th>Jugador</th>
                    <th>Penal</th>
                    <th>Penal Atajado</th>
                    <th>Orden</th>
                    <th>Promotor</th>
                    <th>Errado</th>
                    <th>Amarilla</th>
                    <th>Roja</th>
                    <th>Inasistencia</th>
                    <th>Inasistencia amigo</th>
                    <th>Puntos</th>
                </tr>
                <?php
                    
                    if(!empty($puntosInfo))
                    {
                        foreach($puntosInfo as $player)
                        {
 $puntos = ($player->penalMetido * 2) + ($player->penalAtajado * 2) + $player->orden + ($player->penalErrado * -5) + $player->promotor + ($player->tarjetaAmarilla * -3) + ($player->tarjetaRoja * -6) + ($player->inasistencia * -10) + ($player->inasistenciaAmigo * -5)
                    ?>
                    <tr>
                        <td><?php echo $player->first_name ." ". $player->last_name ;?></td>
                        <td><?php echo $player->penalMetido ;?></td>
                        <td><?php echo $player->penalAtajado ; ?></td>
                        <td><?php echo $player->orden ; ?></td>
                        <td><?php echo $player->promotor ; ?></td>
                        <td><?php echo $player->penalErrado ; ?></td>
                        <td><?php echo $player->tarjetaAmarilla ; ?></td>
                        <td><?php echo $player->tarjetaRoja ; ?></td>
                        <td><?php echo $player->inasistencia ; ?></td>
                        <td><?php echo $player->inasistenciaAmigo ; ?></td>
                        <td><?php echo $puntos ; ?></td>
                    </tr>

                    <?php

                        }
                    }
                    
                    ?>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php } ?>
            <?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php unset($_SESSION['success']); ?>
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