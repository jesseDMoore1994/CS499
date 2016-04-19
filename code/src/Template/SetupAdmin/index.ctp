<div class="admin-page">
	<div class="admin-page-top">

		<!--<div class="admin-page-actionbutton">
			<div class="button"><a href=""><span class="icomoon">&#xe991;</span><span>Edit Settings</span></a></div>
		</div>-->

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>

	<?php if (isset($theater)) { ?>
	<div class="admin-settings">

		<div class="admin-setting">
			<div class="admin-setting-edit">
				<a href="" class="caps">Edit</a>
			</div>
			<div class="admin-setting-name">
				<strong>Theater Name</strong>
			</div>
			<div class="admin-setting-value">
				<?= $theater->name ?>
			</div>
		</div>

		<div class="admin-setting">
			<div class="admin-setting-edit">
				<a href="" class="caps">Edit</a>
			</div>
			<div class="admin-setting-name">
				<strong>Theater Location</strong>
			</div>
			<div class="admin-setting-value">
				<?= $theater->location ?>
			</div>
		</div>

		<div class="admin-setting">
			<div class="admin-setting-edit">
				<a href="" class="caps">Edit</a>
			</div>
			<div class="admin-setting-name">
				<strong>Theater Description</strong>
			</div>
			<div class="admin-setting-value">
				<?= substr($theater->description, 0, 100) ?>
				<?php if (strlen($theater->description) > 100) echo "..." ?>
			</div>
		</div>

		<div class="admin-setting">
			<div class="admin-setting-edit">
				<a href="" class="caps">Edit</a>
			</div>
			<div class="admin-setting-name">
				<strong>Local Sales Tax</strong>
			</div>
			<div class="admin-setting-value">
				$<?= $theater->sales_tax ?>
			</div>
		</div>

	</div>
	<?php } ?>

</div>