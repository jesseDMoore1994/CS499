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
	<?= $this->Html->css('banner.css') ?>
	<?= $this->Html->css('auth.css') ?>
	<?= $this->Html->script('jquery') ?>
	<?= $this->Html->script('app.js') ?>
	<?= $this->Html->script('responsive.js') ?>

	<?php if (isset($css)) foreach ($css as $c) { ?>
		<?= $this->Html->css($c) ?>
	<?php } ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body class="layout-auth">
	<div class="wrap">
		<?= $this->fetch("content") ?>
		<div class="push"></div>
	</div>
	<div class="footer">
		<?= $this->element('footer/footer') ?>
	</div>
</body>
</html>
