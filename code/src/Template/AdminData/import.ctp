<div class="admin-page">
    <?= $this->element("admin/top",[
        "title" => "Import / Export",
        "description" => "Page for Import of Database Information."
    ]) ?>

    <div class="admin-results">
        <div class="admin-results-title responsive">
            <div class="admin-results-title responsive-inner">
                <?= $this->element("admin/data/importExportLinks",[
                ]) ?>


            </div>
        </div>
    </div>
    Pick a table to Import.
    <?= $this->Form->select('table', ['Tickets','Staff Assignments', 'Users']) ?>


    <?php echo $this->Html->link(
        'Import Table',
        '/admindata/export/',
        ['controller' => 'AdminData', 'action' => 'export']);
    ?>
</div>