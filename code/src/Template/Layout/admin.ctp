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
		<div class="admin-logo">
			<h1>Theater Management Console</h1>
		</div>
		<div class="admin-nav">
			<div class="admin-tools">
				<div class="admin-tool">
					<span class="icomoon"><a href="" title="Sign out and return to site">&#xea14;</a></span>
				</div>
			</div>
			<div class="admin-panel-select">
				<select>
					<optgroup label="Theaters">
						<option>Civic Center Playhouse</option>
						<option>Civic Center Concert Hall</option>
					</optgroup>
					<optgroup label="Administrator Tools">
						<option>Site Administration Console</option>
					</optgroup>
				</select>
			</div>
			<div class="admin-tab selected">
				<a href="<?= $this->Url->build("/admin/tickets/", true) ?>"><span class="icomoon">&#xe939;</span> <span>Ticket Search</span></a>
			</div>
			<div class="admin-tab">
				<a href="<?= $this->Url->build("/admin/tickets/", true) ?>"><span class="icomoon">&#xe971;</span> <span>Customer Search</span></a>
			</div>
			<div class="admin-tab">
				<a href="<?= $this->Url->build("/admin/schedule/", true) ?>"><span class="icomoon">&#xe953;</span> <span>Theater Schedule</span></a>
			</div>
			<div class="admin-tab">
				<a href="<?= $this->Url->build("/admin/setup/", true) ?>"><span class="icomoon">&#xe994;</span> <span>Theater Setup</span> <span class="icomoon lock">&#xe98f;</span></a>
			</div>
		</div>
		<div class="admin-body">
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>
</body>
</html>


