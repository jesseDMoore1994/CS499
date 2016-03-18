<div class="site_content">
	<div class="site_itemlist responsive-inner">

		<div class="site_itemlist_top">

			<div class="site_itemlist_topleft">
				<img src="<?= $this->Url->build('/img/home/'.$theater_id.'.png', true) ?>" />
			</div>

			<div class="site_itemlist_topcenter">
				<div class="site_itemlist_topcenter_headings">
					<h1><?= $theater_name ?></h1>
					<h2><?= $theater_location ?></h2>
				</div>
			</div>

		</div>

		<div class="site_itemlist_body">

			<table>
				<tr>
					<th>Performance</th>
					<th>Playwright</th>
					<th>Performance Date</th>
					<th>Performance Time</th>
					<th></th>
				</tr>
				<?php foreach ($theater_performances as $performance) { ?>
				<tr>
					<td><?= $performance[0] ?></td>
					<td><?= $performance[1] ?></td>
					<td><?= $performance[2] ?></td>
					<td><?= $performance[3] ?></td>
					<td>
						<a href="<?= $this->Url->build('/', true) ?>" class="caps">Buy Tickets</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<div class="site_itemlist_about">
				<h2>About the <?= $theater_name ?></h2>
				<p><?= $theater_about ?></p>
			</div>

		</div>



		<div class="site_itemlist_footer">

		</div>

	</div>
</div>