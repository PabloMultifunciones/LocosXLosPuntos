 <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>LX</b>LP</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>LX</b>LP</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <li class="dropdown tasks-menu">
                <a href="<?php echo base_url()."logout"?>" >
                  <i class="fa fa-history"></i>
                  <span class="hidden-xs">Cerrar Sesion</span>
                </a>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo base_url(); ?>dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Usuarios</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>salaListing" >
                <i class="fa fa-futbol-o"></i>
                <span>Salas</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>canchaListing" >
                <i class="fa fa-star"></i>
                <span>Canchas</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>playerListing">
                <i class="fa fa-users"></i>
                <span>Jugadores</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>puntosListing">
                <i class="fa fa-trophy"></i>
                <span>Puntos</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>preinscriptos">
                <i class="fa fa-users"></i>
                <span>Preinscriptos</span>
              </a>
            </li>
           
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>