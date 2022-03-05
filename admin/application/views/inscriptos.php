<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Gestion de salas
        <small>Inscripciones</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewSala"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Salas</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>salaListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Jugador</th>
                        <th>Equipo</th>
                        <th>Arquero</th>
                        <th>Pago</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($jugadoresRecords))
                    {
                        foreach($jugadoresRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->idJugador ?></td>
                        <td><?php echo $record->first_name." ".$record->last_name ;  ?></td>
                        <td><?php echo $record->equipo ?></td>
                        <td><?php echo ($record->arquero == "1") ? "Si" : "No" ;?></td>
                        <td><?php echo ($record->pago == "1") ? "Si" : "No" ;?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger deleteInscripcion" href="#" data-userid="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>

                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            <div class="row">
                <div class="col-xs-12 text-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="<?php  if(!empty($jugadoresRecords)){echo base_url().'pasarResultados/'.$record->idSala; }; ?>">Pasar resultados</a>
                    </div>
                </div>
            </div>
<h3 class="box-title">Suplentes</h3>
                  <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Jugador</th>
                        <th>Email</th>
                        <th>Telefono</th>
                    </tr>
                    <?php
                    if(!empty($suplentes))
                    {
                        foreach($suplentes as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->idJugador ?></td>
                        <td><?php echo $record->nombre." ".$record->apellido ;  ?></td>
                        <td><?php echo $record->email ?></td>
                        <td><?php echo $record->telefono;?></td>
 
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>

            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "salaListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
