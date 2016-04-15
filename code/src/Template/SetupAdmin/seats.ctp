<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-actionbutton">
			<div class="button"><a href="javascript:showSectionDialog()"><span class="icomoon">&#xea0a;</span><span>Create Section</span></a></div>
		</div>

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>

	<div class="section-creator dialog" title="Create Section">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/seasons/api_create/", true) ?>">
			<label>Section Name:</label>
			<input type="text" name="name" class="name" />
			<label>Number of Rows:</label>
			<input type="text" name="rows" class="rows" />
			<label>Number of Seats per Row:</label>
			<input type="text" name="seats" class="seats" />
			<label>Section Code (Example: A):</label>
			<input type="text" name="code" class="code" maxlength="1" />
			<label>Seat Price:</label>
			<input type="text" name="price" class="price" value="10.00" />

			<em>
				Note: The values you enter above will be used as defaults
				when creating this section. You can always go back and
				change individual seat prices or add/remove individual
				seats.
			</em>
		</form>
	</div>

	<div class="row-creator dialog" title="Create Row">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/seasons/api_create/", true) ?>">
			<label>Row Code (Example: B):</label>
			<input type="text" name="code" class="code" maxlength="1" />
			<label>Number of Seats:</label>
			<input type="text" name="seats" class="seats" />
			<label>Seat Price:</label>
			<input type="text" name="price" class="price" value="10.00" />

			<em>
				Note: The values you enter above will be used as defaults
				when creating this row. You can always go back and
				change individual seat prices or add/remove individual
				seats.
			</em>
		</form>
	</div>

	<div class="seat-creator dialog" title="Create Seat">
		<form class="dialog-form" action="<?= $this->Url->build("/admin/seasons/api_create/", true) ?>">
			<label>Seat Number (Example: 23):</label>
			<input type="text" name="code" class="code" maxlength="3" />
			<label>Seat Price:</label>
			<input type="text" name="price" class="price" value="10.00" />
		</form>
	</div>

	<div class="row-editor dialog" title="Edit Row">
		<form class="dialog-form">
			<label>Row Code (Example: B):</label>
			<input type="text" name="code" class="code" maxlength="1" />
		</form>
	</div>

	<div class="seat-editor dialog" title="Edit Seat">
		<form class="dialog-form">
			<label>Seat Number (Example: 23):</label>
			<input type="text" name="code" class="code" maxlength="3" />
			<label>Price:</label>
			<input type="text" name="price" class="price" />
		</form>
	</div>

	<div class="section-editor dialog" title="Edit Section">
		<form class="dialog-form">
			<label>Seat Name:</label>
			<input type="text" name="name" class="name" />
			<label>Seat Code (Example: M):</label>
			<input type="text" name="code" class="code" maxlength="1" />
		</form>
	</div>

	<div class="admin-sections">
		<?php foreach ($sections as $section) { ?>
		<div class="admin-section">
			<h1><?= $section["name"] ?> Seating <a href="javascript:showSectionEditorDialog(<?= $section["id"] ?>, '<?= $section["name"] ?>', '<?= $section["code"] ?>')" class="icomoon" style="font-size:50%;">&#xe905;</a></h1>
			<?php foreach ($section["rows"] as $row) { $i = 1; ?>
			<div class="admin-row">
				<strong><a href="javascript:showRowEditorDialog(<?= $row["id"] ?>, '<?= $row["code"] ?>')">Row <?= $row["code"] ?></a></strong>
				<?php foreach ($row["seats"] as $seat) { ?>
				<span class="admin-seat"><a href="javascript:showSeatEditorDialog(<?= $seat->id ?>, '<?= $seat->price ?>', '<?= $seat->code ?>')"><?= $row["code"].$seat->code ?></a></span>
				<?php if ($i != 0 && $i % 20 == 0) { echo "<br /><div class='indent'></div>"; } ?>
				<?php $i++; } ?>
				<span class="admin-seat admin-seat-create icomoon"><a href="javascript:showSeatDialog(<?= $section["id"] ?>, <?= $row["id"] ?>)">&#xea0a;</a></span>
			</div>
			<?php } ?>
			<div class="admin-row admin-row-add">
				<a href="javascript:showRowDialog(<?= $section["id"] ?>)" class="admin-add-row"><span class="icomoon">&#xea0a;</span> Add Row</a>
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