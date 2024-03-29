
<div class="customer-creator dialog" title="Create Account">
	<form class="dialog-form">
		<label>Full Name:</label>
		<input type="text" placeholder="Jane Doe" class="customer-name" />
		<label>Email:</label>
		<input type="text" placeholder="jdoe456@example.com" class="customer-email" />
		<label>Access Level:</label>
		<select id="access-level" class="access-level">
			<option value="0">Customer</option>
			<option value="1">Cashier</option>
			<option value="2">Administrator</option>
		</select>

		<div class="customer-creator-edit">
			<label>Change Password?:</label>
			<select id="customer-creator-changepassword">
				<option value="0">No, do not change</option>
				<option value="1">Yes, change password</option>
			</select>
		</div>

		<div id="customer-creator-changepasswordoptions" class="customer-creator-new">
			<label>Password:</label>
			<input type="password" class="password" />
			<label>Password (Re-Type):</label>
			<input type="password" class="password_confirm" />
		</div>
	</form>
</div>