<div class="site-tickets site-page">
	<div class="site-tickets-inner responsive-inner">
		<div class="site-tickets-top">
			<div class="site-tickets-logo">
				<a href="<?= $this->Url->build('/performances/', true) ?>"><span class="icomoon">&#xe939;</span></a>
			</div>
			<div class="site-tickets-nav site-tickets-nav-right">
				<?php foreach ($tabs as $tab) if ($tab[2] == "right") { ?>
					<div class="site-tickets-nav-item<?php if ($mode == $tab[0]) echo " selected"; ?>">
						<a href="<?= $this->Url->build('/performances/index/'.$tab[0].'/', true) ?>"><?= $tab[1] ?></a>
					</div>
				<?php } ?>
			</div>
			<div class="site-tickets-nav">
				<?php foreach ($tabs as $tab) if ($tab[2] == "left") { ?>
					<div class="site-tickets-nav-item<?php if ($mode == $tab[0]) echo " selected"; ?>">
						<a href="<?= $this->Url->build('/performances/index/'.$tab[0].'/', true) ?>"><?= $tab[1] ?></a>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="site-tickets-main">
			<?php if (isset($plays)) foreach ($plays as $play) { ?>
			<div class="site-tickets-play">
				<div class="site-tickets-play-image">
					<img src="<?= $this->Url->build('/img/plays/'.$play[0].'.png', true) ?>" />
				</div>
				<div class="site-tickets-play-body">
					<h2><?= $play[1] ?></h2>
					<table>
						<tr>
							<th>Performance Time</th>
							<th>Theater</th>
							<th>Seating</th>
							<th></th>
						</tr>
						<?php foreach ($play[2] as $performance) { ?>
						<tr>
							<td><?= $performance[1] ?></td>
							<td><?= $performance[2] ?></td>
							<td>
								<?php if ($performance[3] > 0) { ?>
								<span class="good"><?= $performance[3] ?> seats available</span>
								<?php } else { ?>
								<span class="bad">0 seats available</span>
								<?php } ?>
							</td>
							<td style="text-align:right;"><a href="<?= $this->Url->build('/performances/view/'.$performance[0].'/'.$performance[4].'/', true) ?>" class="caps">Buy Tickets</a></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			<?php } ?>

			<?php if (isset($seasons)) { ?>
			<div class="season-tickets-wrap">

				<?php if (count($seasons) > 0) { ?>
				<h2>Current Seasons</h2>
				<table class="season-tickets">
					<tr>
						<th>Season Name</th>
						<th style="width:200px;">Sales Begin</th>
						<th style="width:200px;">Sales End</th>
						<th style="width:100px;"></th>
					</tr>
					<?php foreach($seasons as $season) { ?>
						<tr>
							<td><?= $season->name ?></td>
							<td><?= date("M d Y, h:i", $season->start_time) ?></td>
							<td><?= date("M d Y, h:i", $season->end_time) ?></td>
							<td style="text-align:right;"><a href="<?= $this->Url->build("/season/view/".$season->id, true) ?>" class="caps">Buy Tickets</a></td>
						</tr>
					<?php } ?>
				</table>
				<?php } ?>

				<?php if (count($past_seasons) > 0) { ?>
				<h2>Past Seasons</h2>
				<table class="season-tickets">
					<tr>
						<th>Season Name</th>
						<th style="width:200px;">Sales Begin</th>
						<th style="width:200px;">Sales End</th>
						<th style="width:100px;"></th>
					</tr>
					<?php foreach($past_seasons as $season) { ?>
						<tr>
							<td><?= $season->name ?></td>
							<td><?= date("M d Y, h:i", $season->start_time) ?></td>
							<td><?= date("M d Y, h:i", $season->end_time) ?></td>
							<td style="text-align:right;"><a href="<?= $this->Url->build("/season/view/".$season->id, true) ?>" class="caps">Buy Tickets</a></td>
						</tr>
					<?php } ?>
				</table>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>