<?php

function startsWith2($haystack, $needle) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

?><div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-tabs">
			<div class="admin-page-tabs-right">
				<div class="admin-page-tab<?php if (startsWith2($this->Url->build(null, true), $this->Url->build("/admin/setup/import/", true))) echo " selected"; ?>">
					<a href="<?= $this->Url->build("/admin/setup/import/") ?>"><span class="icomoon">&#xe9c7;</span> Import</a>
				</div>
				<div class="admin-page-tab<?php if (startsWith2($this->Url->build(null, true), $this->Url->build("/admin/setup/export/", true))) echo " selected"; ?>">
					<a href="<?= $this->Url->build("/admin/setup/export/") ?>"><span class="icomoon">&#xe9c8;</span> Export</a>
				</div>
			</div>
			<div class="admin-page-tab<?php if ($this->Url->build(null, true) == $this->Url->build("/admin/setup/", true)) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/setup/") ?>"><span class="icomoon">&#xe991;</span> General Settings</a>
			</div>
			<div class="admin-page-tab<?php if (startsWith2($this->Url->build(null, true), $this->Url->build("/admin/setup/seats/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/setup/seats/") ?>"><span class="icomoon">&#xea72;</span> Seat Layout</a>
			</div>
			<div class="admin-page-tab<?php if (startsWith2($this->Url->build(null, true), $this->Url->build("/admin/setup/availability/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/setup/availability/") ?>"><span class="icomoon">&#xea07;</span> Seat Availability</a>
			</div>
			<div class="admin-page-tab<?php if (startsWith2($this->Url->build(null, true), $this->Url->build("/admin/setup/staff/", true))) echo " selected"; ?>">
				<a href="<?= $this->Url->build("/admin/setup/staff/") ?>"><span class="icomoon">&#xe976;</span> Staff Accounts</a>
			</div>
		</div>

	</div>
	<div class="admin-top-border"></div>
</div>