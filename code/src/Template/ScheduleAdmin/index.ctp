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
					<a href=""><span class="icomoon">&#xea0a;</span> Schedule Performance</a>
				</div>
			</div>
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

						<tr<?php if ($separatorEnabled && array_key_exists("last", $performance) && $performance["last"]) echo " class='last'" ?>>
							<td><label class="responsive-tip">Performance #:</label> <?= $performance["performance_id"] ?></td>
							<td><label class="responsive-tip">Performance of:</label> <?= $performance["performance_name"] ?></td>
							<td><label class="responsive-tip">Scheduled for:</label> <?= $performance["performance_time"] ?></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $performance["performance_sales_state"] ?>"><?= $performance["performance_sales"] ?></span> / <?= $performance["performance_capacity"] ?></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $performance["performance_state"] ?>"><?= $performance["performance_status"] ?></span></td>
							<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Cancel</a> <a href="" class="caps">Edit</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
							<td><label class="responsive-tip">Select:</label> <input type="checkbox" /></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>