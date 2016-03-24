
<div class="auth-outer">
	<div class="auth">
		<div class="auth-top">
			<div class="auth-cancel"><a href="<?= $this->Url->build('/', true) ?>">Cancel</a></div>
			<div class="auth-logo"><a href="<?= $this->Url->build('/', true) ?>"></a></div>
		</div>
		<div class="auth-body">
			<form class="auth-form">
				<label for="email">Email Address:</label>
				<input type="text" name="email" id="email" />
				<em class="requirement"><a href="<?= $this->Url->build('/auth/forgot/', true) ?>">Forgot password?</a></em>
				<label for="password">Password:</label>
				<input type="password" name="passowrd" id="password" />
				<input type="submit" value="Login In" class="submit" />
				<div class="create-account-notice">
					or <a href="<?= $this->Url->build('/auth/signup/', true) ?>">sign up for an account</a>
				</div>
			</form>
		</div>
	</div>
</div>
