<div class="site_content site-page">
	<div class="site_picturelist responsive-inner">

		<div class="site_picturelist_top">
			<h1>Huntsville Theater Venues</h1>
		</div>

		<div class="site_picturelist_body">

			<?php foreach ($theaters as $theater) { ?>
			<div class="site_picturelist_item">
				<div class="site_piclistitem_left">
					<a href="<?= $this->Url->build("/theater/view/$theater[0]/$theater[1]/", true) ?>"><img src="<?= $this->Url->build('/img/home/'.$theater[0].'.png', true) ?>" /></a>
				</div>

				<div class="site_piclistitem_center">
					<h2><?= $theater[2] ?></h2>

					<p>
						<?= $theater[3] ?>
					</p>

					<div class="site_piclistitem_buttons">
						<div class="site_piclistitem_button site_piclistitem_button_emphasis">
							<a href="<?= $this->Url->build("/theaters/view/$theater[0]/$theater[1]/", true) ?>">View Performances</a>
						</div>
						<div class="site_piclistitem_button">
							<a href="<?= $this->Url->build("/theaters/view/$theater[0]/$theater[1]/", true) ?>">Buy Season Tickets</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>

		<div class="site_picturelist_footer">

		</div>

	</div>
</div>