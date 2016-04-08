<div class="site-performance site-page">
	<div class="site-performance-inner responsive-inner">
		<div class="site-performance-top">
			<div class="site-performance-logo">
				<a href="<?= $this->Url->build('/performances/', true) ?>"><span class="icomoon">&#xe939;</span></a>
			</div>
			<div class="site-performance-breadcrumbs">
				<div class="site-performance-breadcrumb">
					<a href="<?= $this->Url->build("/performances/", true) ?>">Tickets</a>
				</div>
				<div class="site-performance-breadcrumb-separator">
					<span class="icomoon">&#xea3c;</span>
				</div>
				<div class="site-performance-breadcrumb">
					<a href="<?= $this->Url->build("/performances/$performance_id/$play_slug/", true) ?>"><?= $play_name ?></a>
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
				<?php $j = 0; foreach ($sections as $sec) { ?>
				<div class="site-performance-rows-section">
					<div class="site-perfrowsec-right">
						<?= $sec[1] ?>
					</div>
					<div class="site-perfrowsec-left">
						<?= $sec[0] ?>
					</div>
					<div class="site-prefrowsec-rows">
						<?php for ($i = 0; $i < count($sec[2]); $i++) {
						?><div class="site-prefrowsec-row<?php if ($selected_row == $j) echo " selected"; ?>">
							<div class="site-prefrowsec-rowid">
								<a href="<?= $this->Url->build("/performances/view/$performance_id/$play_slug/$j/", true) ?>"><?= $sec[2][$i][0] ?></a>
							</div>
							<div class="site-prefrowsec-seats <?php
								if ($sec[2][$i][1] == 0) { echo "bad"; }
								else if ($sec[2][$i][1] < 3) { echo "warning"; }
								else { echo "good"; } ?>">

								<a href="<?= $this->Url->build("/performances/view/$performance_id/$play_slug/$j/", true) ?>"><?= $sec[2][$i][1] ?></a>
							</div>
						</div><?php $j++; } ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="site-performance-seats">
				<h2>Available Seats for Row <?= (count($seat_options) > 0) ? $seat_options[0] : "N" ?></h2>
				<?php if (count($seat_options) >= 2) for ($i = 0; $i < count($seat_options[2]); $i++) { ?>
				<div class="site-performance-seat">
					<div class="site-performance-seat-cart caps">
						<?php if ($seat_options[3][$i]) { ?>
						<a href="">Add to Cart</a>
						<?php } else { ?>
						--
						<?php } ?>
					</div>
					<div class="site-performance-seat-price">
						<?= ($seat_options[3][$i]) ? "$".$seat_options[3][$i] : "--" ; ?>
					</div>
					<div class="site-performance-seat-availability">
						<a href=""><?= ($seat_options[3][$i]) ? "<span class='good'>Available</span>" : "<span class='bad'>Unavailable</span>" ; ?></a>
					</div>
					<div class="site-performance-seat-name">
						<?= $play_theater ?>,
						<strong>Seat <?= $seat_options[2][$i] ?></strong>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>