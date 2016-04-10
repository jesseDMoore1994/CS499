<div class="page site-page">
	<div class="responsive-inner">
		<div class="page-top">
			<div class="page-icon">
				<span class="icomoon">&#xe93b;</span>
			</div>
			<div class="page-text">
				Checkout
			</div>
		</div>
		<div class="page-main">
			<div class="checkout-success">
				<div class="checkout-success-top">
					<div class="icon">
						<span class="icomoon">&#xea10;</span>
					</div>
					<p>Thank you for your purchase!</p>
				</div>
				<div class="checkout-success-list">
					<h3>Purchased Items</h3>
					<table>
						<tr>
							<th style="width:150px;">Ticket Number</th>
							<th style="width:300px;">Theater</th>
							<th style="width:150px;">Seat</th>
							<th style="width:150px;">Performance</th>
							<th style="width:200px;">Time</th>
							<th style="width:150px;">Status</th>
						</tr>
						<?php foreach ($tickets as $ticket) { ?>
						<tr>
							<td>
								<?= $ticket->id ?>
							</td>
							<td>
								<?= $ticket->theater->name ?>
							</td>
							<td>
								<?= $ticket->section->code.$ticket->row->code."-".$ticket->seat->code ?>
							</td>
							<td>
								<?= $ticket->performance->play->name ?>
							</td>
							<td>
								<?= date("M d Y, h:i", $ticket->performance->start_time) ?>
							</td>
							<td>
								<?= ucfirst($ticket->status) ?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="checkout-success-print">
					<a href="<?= $this->Url->build("/checkout/printer/$pid/", true) ?>" target="_blank"><span class="icomoon">&#xe954;</span><span>Print Receipt</span></a>
				</div>
				<div class="checkout-success-instructions">
					<?= $this->element("checkout/instructions") ?>
				</div>
			</div>
		</div>
	</div>
</div>
