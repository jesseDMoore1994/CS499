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
								<a href=""><?= $sec[2][$i][0] ?></a>
							</div>
							<div class="site-prefrowsec-seats <?php
								if ($sec[2][$i][1] == 0) { echo "bad"; }
								else if ($sec[2][$i][1] < 3) { echo "warning"; }
								else { echo "good"; } ?>">

								<a href=""><?= $sec[2][$i][1] ?></a>
							</div>
						</div><?php $j++; } ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="site-performance-seats">

			</div>
		</div>
	</div>
</div>