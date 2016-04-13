<style type="text/css">

	body {
		padding:20px;
	}

	.footer {
		display:none;
	}

	table {
		width:100%;
	}

	h1 {
		margin-bottom:20px;
		font-size:150%;
		font-weight:bold;
	}

	h2, h3 {
		margin-bottom:20px;
		font-size:120%;
		font-weight:bold;
	}
</style>

<h1>TicketAngel Receipt</h1>

<script type="text/javascript">
	$(document).ready(function() {
		window.print();
	})
</script>

<table>
	<tr>
		<th style="width:150px;">Ticket Number</th>
		<th style="width:300px;">Theater</th>
		<th style="width:150px;">Seat</th>
		<th style="">Performance</th>
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
				<?= ($ticket->performance_id == 0) ? $ticket->season->name : $ticket->performance->play->name ?>
			</td>
			<td>
				<?php if ($ticket->performance_id != 0) { ?>
					<?= date("M d Y, h:i", $ticket->performance->start_time) ?>
				<?php } else { ?>
					--
				<?php } ?>
			</td>
			<td>
				<?= ucfirst($ticket->status) ?>
			</td>
		</tr>
	<?php } ?>
</table>

<?= $this->element("checkout/instructions") ?>