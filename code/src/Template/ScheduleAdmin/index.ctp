<div class="admin-page">
	<div class="admin-page-top">
		<form class="admin-search">
			<div class="admin-controls">
				<div class="admin-controls-search">
					<input type="text" name="search" placeholder="Enter the name of a performance..." />
				</div>
				<div class="admin-controls-button black marginless" style="width:32px;">
					<input type="submit" class="search icomoon" value="&#xe986;" />
				</div>
				<div class="admin-controls-button green" style="width:220px;">
					<a href="javascript:showPerformanceDialog()"><span class="icomoon">&#xea0a;</span> Schedule Performance</a>
				</div>
			</div>
		</form>
	</div>

	<div class="performance-creator dialog" title="Schedule Performance">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/schedule/api_create/", true) ?>">
			<label>Performance Of:</label>
			<select>
				<option>The Tragedy of Othello</option>
			</select>
			<label>Date:</label>
			<input type="text" class="datepicker date" />
			<label>Time:</label>
			<select id="time">
				<?php for ($i = 8; $i < 12; $i++) { ?>
				<option value="<?= $i ?>"><?= $i ?>:00 am</option>
				<?php } ?>
				<option value="12">12:00 pm</option>
				<?php for ($i = 1; $i <= 11; $i++) { ?>
					<option value="<?= 12+$i ?>"><?= $i ?>:00 pm</option>
				<?php } ?>
			</select>
			<label>Sales Open?:</label>
			<select class="open">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
			<label>Canceled?:</label>
			<select class="canceled">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
		</form>
	</div>

	<div class="admin-results">
		<div class="admin-results-list">
			<div class="admin-results-list-inner">
				<table>
					<tr class="table-heading">
						<th style="width:150px;">Seat #</th>
						<th>Performance of</th>
						<th style="width:200px;">Scheduled Time</th>
						<th style="width:100px;">Sales</th>
						<th style="width:100px;">Status</th>
						<th style="width:200px;">Actions</th>
						<th style="width:20px;"></th>
					</tr>
					<?php foreach ($performances as $performance) { ?>

						<?php if (count($performance) == 0) { if ($separatorEnabled) { ?>
						<tr>
							<th colspan="7">Concluded Performances</th>
						</tr>
						<?php } continue; } ?>

						<tr<?php if ($separatorEnabled && array_key_exists("last", $performance) && $performance["last"]) echo " class='last'" ?> id="performance-<?= $performance["performance_id"] ?>">
							<td><label class="responsive-tip">Performance #:</label> <?= $performance["performance_id"] ?></td>
							<td><label class="responsive-tip">Performance of:</label> <?= $performance["performance_name"] ?></td>
							<td><label class="responsive-tip">Scheduled for:</label> <?= $performance["performance_time"] ?></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $performance["performance_sales_state"] ?>"><?= $performance["performance_sales"] ?></span> / <?= $performance["performance_capacity"] ?></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $performance["performance_state"] ?>"><?= $performance["performance_status"] ?></span></td>
							<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Cancel</a> <a href="javascript:showPerformanceEditDialog(<?= $performance["performance_id"] ?>)" class="caps">Edit</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
							<td><label class="responsive-tip">Select:</label> <input type="checkbox" /> <div class="data"><?= json_encode($performance) ?></div></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>