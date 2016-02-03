<?php

$this->start('navigation');
echo $this->element('navigation/login_guest');
echo $this->element('navigation/main');
echo $this->element('navigation/logo');
$this->end();

?>
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
	<div class="homepage responsive">
		<div class="homepage-inner responsive-inner">
			<div class="homepage-theaters">
				<h1><strong>Huntsville's</strong> Finest Productions...</h1>
				<div class="homepage-tiles">
					<div class="homepage-tile homepage-tile-ccph">
						<a href="">Civic Center Playhouse</a>
					</div>
					<div class="homepage-tile homepage-tile-ccch">
						<a href="">Civic Center Concert Hall</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>