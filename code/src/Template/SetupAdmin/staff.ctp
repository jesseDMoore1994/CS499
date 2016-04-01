<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>

	<div class="admin-results">
		<!--<div class="admin-results-title responsive">
			<div class="admin-results-title-inner responsive-inner">
				<h2>Most Recently Purchased Tickets</h2>
			</div>
		</div>-->
		<div class="admin-results-list">
			<div class="admin-results-list-inner">
				<table class="staff-table">
					<tr class="table-heading">
						<th>Name</th>
						<th style="width:200px;">Email</th>
						<th style="width:200px;">Access Level</th>
						<th style="width:200px;">Actions</th>
						<th style="width:20px;"></th>
					</tr>
					<?php foreach ($staff as $member) { ?>
						<tr>
							<td><label class="responsive-tip">Name:</label> <?= $member["name"] ?></td>
							<td><label class="responsive-tip">Email:</label> <a href="mailto:<?= $member["email"] ?>" class="email"><?= $member["email"] ?></a></td>
							<td><label class="responsive-tip">Access:</label> <?= $member["access"] ?></td>
							<td><label class="responsive-tip">Actions:</label> <a href="" class="caps">Revoke</a> <a href="" class="caps">Edit</a> <a href=""><span class="icomoon">&#xea43;</span></a></td>
							<td><label class="responsive-tip">Select:</label> <input type="checkbox" /></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

</div>