<?php
$this->start('navigation');
echo $this->element('navigation/cart');
echo $this->element('navigation/login_admin');
echo $this->element('navigation/main');
echo $this->element('navigation/logo');
$this->end();

function startsWith($haystack, $needle) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

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
	<?= $this->Html->css('../js/jquery-ui/jquery-ui') ?>
	<?= $this->Html->css('../js/jquery-ui/jquery-ui.theme.css') ?>
	<?= $this->Html->script('jquery') ?>
	<?= $this->Html->script('jquery-ui/jquery-ui') ?>
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
<body data-urlbase="<?= $this->Url->build("/", true) ?>">
<div class="wrap admin">
	<div class="admin-container">
		<div class="admin-logo">
			<h1>Theater Management Console</h1>
		</div>
		<div class="admin-nav">
			<div class="admin-tools">
				<div class="admin-tool">
					<span class="icomoon"><a href="<?= $this->Url->build("/", true) ?>" title="Sign out and return to site">&#xea14;</a></span>
				</div>
			</div>
			<div class="admin-panel-select">
				<select class="admin-theater-switcher">

					<?php if (count($adminTheaters) > 0) { ?>
					<optgroup label="Theaters">
						<?php foreach ($adminTheaters as $assignment) { ?>
							<option value="<?= $assignment->theater_id ?>"<?php if ($adminTheater == $assignment->theater_id) { echo " selected='yes'"; } ?>><?= $assignment->theater->name ?></option>
						<?php } ?>
					</optgroup>
					<?php } ?>

					<?php if ($superAdmin) { ?>
					<optgroup label="Administrator Tools">
						<option value="0"<?php if ($adminTheater == 0) { echo " selected='yes'"; } ?>>Site Administration Console</option>
					</optgroup>
					<?php } ?>

				</select>
			</div>
			<div class="admin-tab<?php if (startsWith($this->Url->build(null, true), $this->Url->build("/admin/tickets/", true)) || $this->Url->build(null, true) == $this->Url->build("/admin/", true)) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/tickets/", true) ?>"><span class="icomoon">&#xe939;</span> <span>Ticket Search</span></a>
			</div>
			<?php if ($canManage) { ?>
			<div class="admin-tab<?php if (startsWith($this->Url->build(null, true), $this->Url->build("/admin/customers/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/customers/", true) ?>"><span class="icomoon">&#xe971;</span> <span>Customer Search</span></a>
			</div>
			<div class="admin-tab<?php if (startsWith($this->Url->build(null, true), $this->Url->build("/admin/schedule/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/schedule/", true) ?>"><span class="icomoon">&#xe953;</span> <span>Theater Schedule</span></a>
			</div>
			<div class="admin-tab<?php if (startsWith($this->Url->build(null, true), $this->Url->build("/admin/setup/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/setup/", true) ?>"><span class="icomoon">&#xe994;</span> <span>Theater Setup</span> <span class="icomoon lock"><?= (startsWith($this->Url->build(null, true), $this->Url->build("/admin/setup/", true))) ? "&#xe990;" : "&#xe98f;"; ?></span></a>
			</div>
			<?php } ?>
		</div>
		<div class="admin-body">
			<?= $this->fetch('content') ?>
		</div>
	</div>
	<div class="push"></div>
</div>
<div class="footer admin-footer">
	<div class="product">
		<strong>TicketAngel</strong>
		Theater Management Console
		<em>1.0.0</em>
	</div>
</div>
</body>
</html>


