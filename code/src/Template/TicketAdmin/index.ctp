<div class="admin-page">
	<div class="admin-page-top">
		<form class="admin-search">
			<div class="admin-controls">
				<div class="admin-controls-search">
					<input type="text" name="search" placeholder="Enter the name of a ticket holder, performance, or ticket ID..." />
				</div>
				<div class="admin-controls-button black marginless" style="width:32px;">
					<input type="submit" class="search icomoon" value="&#xe986;" />
				</div>
				<div class="admin-controls-button green" style="width:150px;">
					<a href=""><span class="icomoon">&#xea0a;</span> Create Ticket</a>
				</div>
			</div>
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
				<table>
					<tr class="table-heading">
						<th>Seat #</th>
						<th>Ticket ID</th>
						<th>Performance</th>
						<th>Valid For</th>
						<th>Ticket Holder</th>
						<th>Status</th>
						<th>Actions</th>
						<th></th>
					</tr>
					<?php foreach ($tickets as $ticket) { ?>
					<tr>
						<td><label class="responsive-tip">Seat #:</label> <?= $ticket["seat"] ?></td>
						<td><label class="responsive-tip">Ticket ID:</label> <?= $ticket["id"] ?></td>
						<td><label class="responsive-tip">Performance:</label> <?= $ticket["performance_name"] ?></td>
						<td><label class="responsive-tip">Valid For:</label> <?= $ticket["performance_time"] ?></td>
						<td><label class="responsive-tip">Ticket Holder:</label> <?= $ticket["person_name"] ?></td>
						<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $ticket["payment_state"] ?>"><?= $ticket["payment_status"] ?></span></td>
						<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Mark as Paid</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
						<td><label class="responsive-tip">Select:</label> <input type="checkbox" /></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>