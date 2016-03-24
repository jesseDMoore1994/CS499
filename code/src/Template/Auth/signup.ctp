
<div class="auth-outer">
	<div class="auth">
		<div class="auth-top">
			<div class="auth-cancel"><a href="<?= $this->Url->build('/', true) ?>">Cancel</a></div>
			<div class="auth-logo"><a href="<?= $this->Url->build('/', true) ?>"></a></div>
		</div>
		<div class="auth-body">
			<form class="auth-form">
				<em class="requirement">i.e. John Doe</em>
				<label for="name">Full Name:</label>
				<input type="text" name="name" id="name" />

				<em class="requirement">i.e. jdoe56@example.com</em>
				<label for="email">Email Address:</label>
				<input type="text" name="email" id="email" />

				<em class="requirement">Must be at least 5 characters</em>
				<label for="password">Password:</label>
				<input type="password" name="passowrd" id="password" />

				<em class="requirement">Re-type your password here</em>
				<label for="confirm_password">Confirm Password:</label>
				<input type="password" name="confirm_password" id="confirm_password" />

				<input type="submit" value="Sign Up" class="submit" />
				<div class="create-account-notice">
					or <a href="<?= $this->Url->build('/auth/login/', true) ?>">log into an existing account</a>
				</div>
			</form>
		</div>
	</div>
</div>
