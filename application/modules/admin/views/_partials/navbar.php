<script>
  	var current_url = '<?php echo current_url();?>';
  	var base_url = '<?php echo base_url();?>';
  	var admin_url = '<?php echo base_url('admin');?>' + '/';
  	$('[data-toggle="tooltip"]').tooltip();
</script>
<header class="main-header">
	<a href="" class="logo" style="background: white"><img src="<?php echo base_url() ?>/assets/img/logo-dn.png" width="160px"></a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
            <li class="dropdown appointment-menu" id="appointment-menu">
               <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-clock-o"></i>
               </a>
            </li>
            <li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- <img src="<?php echo $avatar_url; ?>" class="user-image" alt="<?php echo $user->first_name. ' '. $user->last_name; ?>"> -->
						<span class="hidden-xs"><?php echo $user->first_name.' '.$user->last_name; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<p><?php echo $user->first_name.' '.$user->last_name; ?></p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url('admin/user/info'); ?>" class="btn btn-default btn-flat">Thông tin cá nhân</a>
							</div>
							<div class="pull-right">
								<a href="panel/logout" class="btn btn-default btn-flat">Thoát</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>