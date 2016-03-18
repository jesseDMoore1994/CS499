<div class="site-performance">
	<div class="site-performance-inner responsive-inner">
		<div class="site-performance-top">
			<div class="site-performance-logo">
				<a href="<?= $this->Url->build('/performances/', true) ?>"><span class="icomoon">&#xe939;</span></a>
			</div>
			<div class="site-performance-breadcrumbs">
				<div class="site-performance-breadcrumb">
					Tickets
				</div>
				<div class="site-performance-breadcrumb-separator">
					<span class="icomoon">&#xea3c;</span>
				</div>
				<div class="site-performance-breadcrumb">
					<?= $play_name ?>
				</div>
			</div>
		</div>
		<div class="site-performance-body">
			<div class="site-performance-play">
				<div class="site-performance-play-image">
					<img src="<?= $this->Url->build('/img/plays/'.$play_id.'.png', true) ?>" />
				</div>
				<h1><?= $play_name ?></h1>
				<p>
					<?= $play_about ?>
				</p>
				<p>
					<strong><?= $play_theater ?>. <?= $play_date ?>. <?= $play_time ?>.</strong>
				</p>
			</div>
			<div class="site-performance-rows">

			</div>
			<div class="site-performance-seats">

			</div>
		</div>
	</div>
</div>