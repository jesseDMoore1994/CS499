<div class="banner" style="background-image:url(<?= $this->Url->build('/img/banners/'.$banner_image.'.png', true) ?>)" onclick="window.location='<?= $this->Url->build($banner_link) ?>'">
	<div class="banner-text">
		<div class="responsive-inner">
			<h2><a href="<?= $this->Url->build($banner_link) ?>"><?php echo $banner_title ?></a></h2>
			<h3><?php echo $banner_subtitle ?></h3>
		</div>
	</div>
</div>
<div class="content-block content-list">
	<div class="responsive-inner">
		<h2><strong>Upcoming</strong> Performances</h2>

		<?php foreach ($performances as $p) { ?><div class="content-list-item">
				<img src="<?= $this->Url->build('/img/plays/square/'.$p[0].".png", true) ?>" />
				<h3><?= $p[5] ?></h3>
				<div class="details">
					<strong><?= $p[2] ?></strong><br />
					<span><?= $p[3] ?></span>
				</div>
				<div>
					<div class="button call-to-action">
						<a href="<?= $this->Url->build($p[4], true) ?>">Buy Tickets</a>
					</div>
				</div>
			</div><?php } ?>
	</div>
</div>