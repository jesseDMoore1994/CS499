<div class="admin-top-inner responsive-inner">
     To Import:  <?php echo $this->Html->link(
                         'Import',
                         '/admindata/import/',
                         ['controller' => 'AdminData', 'action' => 'import']);
                         ?><br>
     To Export:  <?php echo $this->Html->link(
                         'Export',
                         '/admindata/export/',
                         ['controller' => 'AdminData', 'action' => 'export']);
                         ?>
</div>