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
					<a href="javascript:showCustomerDialog()"><span class="icomoon">&#xea0a;</span> Create Customer</a>
				</div>
			</div>
		</form>
	</div>

	<div class="customer-creator dialog" title="Create Account">
		<form class="dialog-form">
			<label>Full Name:</label>
			<input type="text" placeholder="Jane Doe" />
			<label>Email:</label>
			<input type="text" placeholder="jdoe456@example.com" />
			<label>Access Level:</label>
			<select>
				<option>Customer</option>
				<option>Cashier</option>
				<option>Administrator</option>
			</select>

			<div class="customer-creator-new">
				<label>Password:</label>
				<input type="password" />
				<label>Password (Re-Type):</label>
				<input type="password" />
			</div>

			<div class="customer-creator-edit">
				<label>Change Password?:</label>
				<select id="customer-creator-changepassword">
					<option value="0">No, do not change</option>
					<option value="1">Yes, change password</option>
				</select>
				<div id="customer-creator-changepasswordoptions">
					<label>New Password:</label>
					<input type="password" />
					<label>New Password (Re-Type):</label>
					<input type="password" />
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
						<th style="width:150px;">Customer #</th>
						<th>Full Name</th>
						<th style="width:200px;">Join Date</th>
						<th style="width:200px;">Email</th>
						<th style="width:100px;">Status</th>
						<th style="width:100px;">Actions</th>
						<th style="width:20px;"></th>
					</tr>
					<?php foreach ($customers as $customer) { ?>
						<tr>
							<td><label class="responsive-tip">Customer #:</label> <?= $customer["customer_id"] ?></td>
							<td><label class="responsive-tip">Full Name:</label> <?= $customer["customer_first"] ?> <?= $customer["customer_last"] ?></td>
							<td><label class="responsive-tip">Join Date:</label><?= $customer["customer_joined"] ?></td>
							<td><label class="responsive-tip">Email:</label> <a href="mailto:<?= $customer["customer_email"] ?>" class="email"><?= $customer["customer_email"] ?></a></td>
							<td class="status bad"><label class="responsive-tip">Status:</label> <span class="<?= $customer["customer_state"] ?>"><?= $customer["customer_status"] ?></span></td>
							<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Edit</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
							<td><label class="responsive-tip">Select:</label> <input type="checkbox" /></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>