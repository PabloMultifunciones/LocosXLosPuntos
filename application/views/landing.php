<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('partials/head'); ?>
</head>
<body>
<div id="header">
	<?php $this->load->view('partials/header'); ?>
</div>
<div id="home">
	<?php
	if(!$inscribed)
	{ 
		$this->load->view('partials/inscribite');
	}
	?>
	<div id="salas">
		<?php $this->load->view('partials/salas'); ?>
	</div>
	<div id="tabla">
		<?php $this->load->view('partials/tabla'); ?>
	</div>
</div>

	<?php $this->load->view('partials/footer'); ?>

</body>
</html>