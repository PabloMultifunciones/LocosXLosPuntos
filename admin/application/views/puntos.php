<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Tabla de puntos
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
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
                        <th>Name</th>
                        <th>Puntos</th>
                        <th>PJ</th>
                        <th>PG</th>
                        <th>PE</th>
                        <th>PP</th>
                        <th>Goles</th>
                        <th>Invictos</th>
                        <th>Fair play</th>
                        <th>Pen convertidos</th>
                        <th>Pen Atajados</th>
                        <th>Orden</th>
                        <th>Promotor</th>
                        <th>Pen Errados</th>
                        <th>Amarillas</th>
                        <th>Rojas</th>
                        <th>Inasistencia</th>
                        <th>Inasistencia amigo</th>
                    </tr>
                    <?php
                    if(!empty($playerRecords))
                    {   
                        foreach($playerRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->first_name. " " . $record->last_name ?></td>
                        <td><?php echo $record->puntos ?></td>
                        <td><?php echo $record->jugados ?></td>
                        <td><?php echo $record->ganados ?></td>
                        <td><?php echo $record->empatados ?></td>
                        <td><?php echo $record->perdidos ?></td>
                        <td><?php echo $record->goles ?></td>
                        <td><?php echo $record->invicto ?></td>
                        <td><?php echo $record->fairPlay ?></td>
                        <td><?php echo $record->penales ?></td>
                        <td><?php echo $record->atajados ?></td>
                        <td><?php echo $record->orden ?></td>
                        <td><?php echo $record->promotor ?></td>
                        <td><?php echo $record->errados ?></td>
                        <td><?php echo $record->amarilla ?></td>
                        <td><?php echo $record->roja ?></td>
                        <td><?php echo $record->inasistencia ?></td>
                        <td><?php echo $record->inasistenciaAmigo ?></td>
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
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
