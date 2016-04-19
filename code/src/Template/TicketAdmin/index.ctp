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
				<div class="admin-controls-button green" style="width:175px;">
					<a href="javascript:showTicketDialog(false)"><span class="icomoon">&#xea0a;</span> Create Ticket</a>
				</div>
			</div>
		</form>
	</div>

	<div class="ticket-creator dialog" title="Create Ticket">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/tickets/api_create/", true) ?>">
			<label>Ticket Holder Name:</label>
			<input type="text" placeholder="Jane Doe" class="full-name" />
			<label>Payment Status:</label>
			<select id="ticket-creator-payment-select">
				<option value="paid">Paid</option>
				<option value="paid-cash">Paid (Cash)</option>
				<option value="paid-credit">Unpaid (Credit); Enter credit card now</option>
				<option value="unpaid-cash">Unpaid (Cash); Customer must pay at door</option>
			</select>
			<div id="ticket-creator-payment">
				<hr />
				<label>Credit Card Number:</label>
				<input type="text" placeholder="1234 5678 9012 3456" />
				<label>Expiration Month:</label>
				<select>
					<option>January (1)</option>
					<option>February (2)</option>
					<option>March (3)</option>
					<option>April (4)</option>
					<option>May (5)</option>
					<option>June (6)</option>
					<option>July (7)</option>
					<option>August (8)</option>
					<option>September (9)</option>
					<option>October (10)</option>
					<option>November (11)</option>
					<option>December (12)</option>
				</select>
				<label>Expiration Day:</label>
				<select id="ticket-dialog-expiration">
					<?php for ($i = 1; $i <= 31; $i++) { ?>
					<option><?= $i ?></option>
					<?php } ?>
				</select>
				<label>Expiration Year:</label>
				<input type="text" placeholder="2018" />
				<label>CVV:</label>
				<input type="text" placeholder="123" />
				<hr />
			</div>
			<label>Performance:</label>
			<select>
				<?php foreach ($performances as $performance) { ?>
				<option value="<?= $performance->id ?>"><?= $performance->play->name ?>: <?= date("M d Y, h:i a", $performance->start_time) ?></option>
				<?php } ?>
			</select>
			<!--<label>Seat Number:</label>
			<select>
				<?php foreach ($seats as $seat) { ?>
				<option value="<?= $seat->id ?>"><?= $seat->row->section->code.$seat->row->code."-".$seat->code ?></option>
				<?php } ?>
			</select>-->
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
						<th style="width:150px;">Ticket #</th>
						<th>Seat</th>
						<th>Performance</th>
						<th>Valid For</th>
						<th>Ticket Holder</th>
						<th>Status</th>
						<th>Actions</th>
						<th style="width:20px;"></th>
					</tr>
					<?php foreach ($tickets as $ticket) { ?>
					<tr id="ticket-<?= $ticket["id"] ?>">
						<td><label class="responsive-tip">Ticket #:</label> <?= $ticket["id"] ?></td>
						<td><label class="responsive-tip">Seat:</label> <?= $ticket["seat"] ?></td>
						<td><label class="responsive-tip">Performance:</label> <?= $ticket["performance_name"] ?></td>
						<td><label class="responsive-tip">Valid For:</label> <?= $ticket["performance_time"] ?></td>
						<td><label class="responsive-tip">Ticket Holder:</label> <?= $ticket["person_name"] ?></td>
						<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $ticket["payment_state"] ?>"><?= $ticket["payment_status"] ?></span></td>
						<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Mark as Paid</a> <a href="javascript:showTicketEditDialog('<?= $ticket["id"] ?>')">EDIT</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
						<td><label class="responsive-tip">Select:</label> <input type="checkbox" /><div class="data"><?= json_encode($ticket) ?></div></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>