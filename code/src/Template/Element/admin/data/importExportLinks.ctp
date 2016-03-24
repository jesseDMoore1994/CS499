<div class="admin-top responsive">
	<div class="admin-top-inner responsive-inner">
         <?php echo $this->Html->link(
                             'Import',
                             '/admindata/import/',
                             ['controller' => 'AdminData', 'action' => 'import']);
                             ?>
         <?php echo $this->Html->link(
                             'Export',
                             '/admindata/export/',
                             ['controller' => 'AdminData', 'action' => 'export']);
                             ?>
	</div>
</div>