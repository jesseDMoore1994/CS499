<?php
$this->start('navigation');
echo $this->element('navigation/cart');
echo $this->element('navigation/login_admin');
echo $this->element('navigation/main');
echo $this->element('navigation/logo');
$this->end();

$this->start('adminheader');
echo $this->element('admin/menu/title');
echo $this->element('admin/menu/module_tickets');
echo $this->element('admin/menu/module_users');
echo $this->element('admin/menu/module_setup');
$this->end();

?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->css('base.css') ?>
	<?= $this->Html->css('app.css') ?>
	<?= $this->Html->css('admin.css') ?>
	<?= $this->Html->script('jquery') ?>
	<?= $this->Html->script('app.js') ?>
	<?= $this->Html->script('responsive.js') ?>
	<?= $this->Html->script('admin.js') ?>

	<?php if (isset($css)) foreach ($css as $c) { ?>
		<?= $this->Html->css($c) ?>
	<?php } ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
<div class="wrap admin">
	<div class="admin-container">
		<div class="admin-nav">
			<div class="admin-header">
				<h1>Management Console</h1>
			</div>
			<div class="admin-picker">
				<select>
					<option>Civic Center Playhouse</option>
					<option>Civic Center Concert Hall</option>
					<option>Super Administrator Console</option>
				</select>
			</div>
			<div class="admin-tabs">
				<div class="admin-tabs-group">
					<h2>Customer Management</h2>
					<div class="admin-tabs-group-items">
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe939;</span> <span>Ticket Search</span></a>
						</div>
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe971;</span> <span>Ticket Search</span></a>
						</div>
					</div>
				</div>
			</div>
			<div class="admin-tabs">
				<div class="admin-tabs-group">
					<h2>Theater Management</h2>
					<div class="admin-tabs-group-items">
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe953;</span> <span>Theater Schedule</span></a>
						</div>
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe90d;</span> <span>Theater Setup</span></a>
						</div>
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe976;</span> <span>Staff Accounts</span></a>
						</div>
						<div class="admin-tab">
							<a href=""><span class="icomoon">&#xe994;</span> <span>General Settings</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="admin-body">
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>
</body>
</html>


