<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>
	<div class="admin-sections">
		<?php foreach ($sections as $section) { ?>
			<div class="admin-section">
				<h1><?= $section["name"] ?> Seating</h1>
				<?php foreach ($section["rows"] as $row) { ?>
					<div class="admin-row">
						<strong>Row <?= $row["code"] ?></strong>
						<?php foreach ($row["seats"] as $seat) { ?>
							<span class="admin-seat"><a href=""><?= $seat ?></a></span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>