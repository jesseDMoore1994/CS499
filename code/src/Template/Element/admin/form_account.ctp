

<div class="customer-creator dialog" title="Create Account">
	<form class="dialog-form">
		<label>Full Name:</label>
		<input type="text" placeholder="Jane Doe" class="customer-name" />
		<label>Email:</label>
		<input type="text" placeholder="jdoe456@example.com" class="customer-email" />
		<label>Access Level:</label>
		<select id="access-level">
			<option value="0">Customer</option>
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