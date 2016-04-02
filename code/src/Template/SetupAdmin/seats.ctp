<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-actionbutton">
			<div class="button"><a href=""><span class="icomoon">&#xea0a;</span><span>Create Section</span></a></div>
		</div>

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>
	<div class="admin-sections">
		<?php foreach ($sections as $section) { ?>
		<div class="admin-section">
			<h1><?= $section["name"] ?> Seating</h1>
			<?php foreach ($section["rows"] as $row) { $i = 1; ?>
			<div class="admin-row">
				<strong>Row <?= $row["code"] ?></strong>
				<?php foreach ($row["seats"] as $seat) { ?>
				<span class="admin-seat"><a href=""><?= $seat ?></a></span>
				<?php if ($i != 0 && $i % 20 == 0) { echo "<br /><div class='indent'></div>"; } ?>
				<?php $i++; } ?>
				<span class="admin-seat admin-seat-create icomoon"><a href="">&#xea0a;</a></span>
			</div>
			<?php } ?>
			<div class="admin-row admin-row-add">
				<a href="" class="admin-add-row"><span class="icomoon">&#xea0a;</span> Add Row</a>
			</div>
		</div>
		<?php } ?>
	</div>
	<!--
	<div class="section-create admin-buttonpanel">
		<div class="button call-to-action">
			<span class="icomoon">&#xea0a;</span> <span>Create Section</span>
		</div>
	</div>-->
</div>