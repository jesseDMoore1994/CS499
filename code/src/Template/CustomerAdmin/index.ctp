<div class="admin-page">
	<div class="admin-page-top">
		<form class="admin-search">
			<div class="admin-controls">
				<div class="admin-controls-search">
					<input type="text" name="search" placeholder="Enter a customer's name, email, or ID number..." />
				</div>
				<div class="admin-controls-button black marginless" style="width:32px;">
					<input type="submit" class="search icomoon" value="&#xe986;" />
				</div>
				<div class="admin-controls-button green" style="width:175px;">
					<a href="javascript:showCustomerDialog(false)"><span class="icomoon">&#xea0a;</span> Create Customer</a>
				</div>
			</div>
		</form>
	</div>

	<?= $this->Element("admin/form_account") ?>

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
						<th style="width:150px;">Customer #</th>
						<th>Full Name</th>
						<th style="width:200px;">Join Date</th>
						<th style="width:200px;">Email</th>
						<th style="width:100px;">Status</th>
						<th style="width:100px;">Actions</th>
						<th style="width:20px;"></th>
					</tr>
					<?php foreach ($customers as $customer) { ?>
						<tr id="customer-<?= $customer["id"] ?>">
							<td><label class="responsive-tip">Customer #:</label> <?= $customer["id"] ?></td>
							<td><label class="responsive-tip">Full Name:</label> <?= $customer["name"] ?></td>
							<td><label class="responsive-tip">Join Date:</label><?= $customer["joined"] ?></td>
							<td><label class="responsive-tip">Email:</label> <a href="mailto:<?= $customer["email"] ?>" class="email"><?= $customer["email"] ?></a></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $customer["state"] ?>"><?= $customer["status"] ?></span></td>
							<td><label class="responsive-tip">Actions:</label> <a href="javascript:showCustomerEditDialog(false, <?= $customer["id"] ?>)" class="caps">Edit</a> <!--<a href=""><span class="icomoon">&#xea43;</span></a>--></td>
							<td><label class="responsive-tip">Select:</label> <input type="checkbox" /><div class="data"><?= json_encode($customer) ?></div></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>