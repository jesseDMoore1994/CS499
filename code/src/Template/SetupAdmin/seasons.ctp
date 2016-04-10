<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-actionbutton">
			<div class="button"><a href="javascript:showSeasonDialog()"><span class="icomoon">&#xea0a;</span><span>Add Season</span></a></div>
		</div>

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>

	<div class="seasons-creator dialog" title="Schedule Performance">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/seasons/api_create/", true) ?>">
			<label>Season Name:</label>
			<input type="text" name="name" class="name" />
			<label>Date Sales Open:</label>
			<input type="text" name="start" class="start datepicker" />
			<label>Date Sales Close:</label>
			<input type="text" name="end" class="end datepicker" />
			<label>Ticket Price:</label>
			<input type="text" name="price" class="price" />
		</form>
	</div>

	<div class="admin-results">
		<!--<div class="admin-results-title responsive">
			<div class="admin-results-title-inner responsive-inner">
				<h2>Most Recently Purchased Tickets</h2>
			</div>
		</div>-->
		<div class="admin-results-list">
			<div class="admin-results-list-inner">
				<table class="staff-table">
					<tr class="table-heading">
						<th>Name</th>
						<th style="width:200px;">Start Time</th>
						<th style="width:200px;">End Time</th>
						<th style="width:200px;">Actions</th>
					</tr>
					<?php foreach ($seasons as $season) { ?>
						<tr id="season-<?= $season->id ?>">
							<td><label class="responsive-tip">Name:</label> <?= $season->name ?></td>
							<td><label class="responsive-tip">Name:</label> <?= date("M d Y, h:i", $season->start_time) ?></td>
							<td><label class="responsive-tip">Name:</label> <?= date("M d Y, h:i", $season->end_time) ?></td>
							<td><label class="responsive-tip">Actions:</label> <a href="javascript:showSeasonEditDialog(<?= $season->id ?>)" class="caps">Edit</a> <a href=""><span class="icomoon">&#xea43;</span></a><div class="data"><?= json_encode([
										"name" => $season->name,
										"start" => date("m/d/Y", $season->start_time),
										"end" => date("m/d/Y", $season->end_time),
										"price" => $season->ticket_price
									]) ?></div></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

</div>