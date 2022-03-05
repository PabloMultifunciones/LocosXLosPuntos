<div class="container">
	<h3>Tu opinión nos interesa</h3>
            <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 well">
            <?php $attributes = array("class" => "form-horizontal", "name" => "contactform");
            echo form_open("landing/contact", $attributes);?>
            <fieldset>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="name" class="control-label">Nombre Completo</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" name="name" type="text" value="<?php echo set_value('name'); ?>" />
                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="email" class="control-label">Correo de contacto</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" name="email" type="text" value="<?php echo set_value('email'); ?>" />
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="email" class="control-label">Telefono de contacto</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" name="phone" type="text" value="<?php echo set_value('phone'); ?>" />
                    <span class="text-danger"><?php echo form_error('phone'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="subject" class="control-label">Asunto</label>
                </div>
                <div class="col-md-12">
                    <input class="form-control" name="subject" type="text" value="<?php echo set_value('subject'); ?>" />
                    <span class="text-danger"><?php echo form_error('subject'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="message" class="control-label">Sugerencia</label>
                </div>
                <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="4" ><?php echo set_value('message'); ?></textarea>
                    <span class="text-danger"><?php echo form_error('message'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <input name="submit" type="submit" class="btn btn-primary" value="Enviar" />
                </div>
            </div>
            </fieldset>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
</div>