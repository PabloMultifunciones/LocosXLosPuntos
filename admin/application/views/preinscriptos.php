<?php
$this->session->set_flashdata('jugador_success' , false);
$this->session->set_flashdata('jugador_updated' , false);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Preinscriptos
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Preinscriptos</h3>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Nombre y Apellido</th>
                        <th>Whatsapp</th>
                        <th>Email</th>
                        <th>Localidad</th>
                    </tr>
                    <?php
                    if(!empty($preinscriptos))
                    {
                        foreach($preinscriptos as $preinscripto)
                        {
                    ?>
                    <tr>
                        <td><?php echo $preinscripto->id ?></td>
                        <td><?php echo $preinscripto->nombreyapellido ?></td>
                        <td><?php echo $preinscripto->whatsapp ?></td>
                        <td><?php echo $preinscripto->email ?></td>
                        <td><?php echo $preinscripto->localidad ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
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
            jQuery("#searchList").attr("action", baseURL + "playerListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
