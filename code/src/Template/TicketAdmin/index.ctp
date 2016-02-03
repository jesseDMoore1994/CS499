<div class="admin-page">
	<?= $this->element("admin/top",[
		"title" => "Ticket Search",
		"description" => "View information on tickets here",
		"help" => "Hello, World!"
	]) ?>

	<div class="admin-results">
		<div class="admin-search responsive">
			<div class="admin-search-inner responsive-inner">
				<form>
					<div class="admin-search-item admin-search-label"><label>Lookup a Ticket:</label></div>
					<div class="admin-search-item"><input type="text" placeholder="" /></div>
					<div class="admin-search-item admin-search-select"><select>
						<option>Ticket ID</option>
					</select></div>
					<div class="admin-search-item admin-search-submit"><input type="submit" value="Search" /></div>
				</form>
			</div>
		</div>
		<div class="admin-results-title responsive">
			<div class="admin-results-title-inner responsive-inner">
				<h2>Most Recently Purchased Tickets</h2>
			</div>
		</div>
		<div class="admin-results-list responsive">
			<div class="admin-results-list-inner responsive-inner">
				<table>
					<tr class="table-heading">
						<th>Seat #</th>
						<th>Ticket ID</th>
						<th>Performance</th>
						<th>Valid For</th>
						<th>Ticket Holder</th>
						<th>Status</th>
						<th>Actions</th>
						<th></th>
					</tr>
					<tr>
						<td><label class="responsive-tip">Seat #:</label> Seat F12</td>
						<td><label class="responsive-tip">Ticket ID:</label> 123456-F12</td>
						<td><label class="responsive-tip">Performance:</label> Macbeth</td>
						<td><label class="responsive-tip">Valid For:</label> Today, 10:00 pm</td>
						<td><label class="responsive-tip">Ticket Holder:</label> Jane Doe</td>
						<td class="status bad"><label class="responsive-tip">Status:</label> Unpaid (Cash)</td>
						<td><label class="responsive-tip">Actions:</label> <a href="">Mark as Paid</a></td>
						<td><label class="responsive-tip">Select:</label> <input type="checkbox" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>