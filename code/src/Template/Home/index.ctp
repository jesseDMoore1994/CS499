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
			<div class="menu-responsive"><a href="#"></a></div>
			<?= $this->fetch('navigation') ?>
		</div>
	</div>
	<div class="homepage-plays responsive">
		<div class="homepage-plays-inner responsive-inner">
			<div class="homepage-play homepage-play-othello"><a href="">Othello</a></div>
			<div class="homepage-play homepage-play-macbeth"><a href="">Macbeth</a></div>
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
						<a href="<?= $this->Url->build('/performances/view/ccph/civic-center-playhouse/', true) ?>">Civic Center Playhouse</a>
					</div>
					<div class="homepage-tile homepage-tile-ccch">
						<a href="<?= $this->Url->build('/performances/view/ccch/civic-center-concert-hall/', true) ?>">Civic Center Concert Hall</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>