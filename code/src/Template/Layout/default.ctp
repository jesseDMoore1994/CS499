<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$this->start('navigation');
echo $this->element('navigation/login_guest');
echo $this->element('navigation/main');
echo $this->element('navigation/logo');
//echo $this->element('sidebar/recent_topics');
//echo $this->element('sidebar/recent_comments');
$this->end();


$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $cakeDescription ?>:
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->css('base.css') ?>
	<!--<?= $this->Html->css('cake.css') ?>-->
	<?= $this->Html->css('app.css') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
	<div class="wrap">
		<div class="header">
			<div class="navigation">
				<div class="navigation-inner responsive-inner">
					<?= $this->fetch('navigation') ?>
				</div>
			</div>
		</div>
		<div class="flash">
			<div class="flash-inner responsive-inner">
				<?= $this->Flash->render() ?>
			</div>
		</div>
		<div class="body">
			<?= $this->fetch('content') ?>
		</div>
	</div>
</body>
</html>
