<div class="admin-results-title responsive">
    <?= $this->element("admin/top",[
        "title" => "Import / Export",
        "description" => "Page for Export of Database Information."
    ]) ?>

    <?= $this->element("admin/data/importExportLinks",[
    ]) ?>



    </div>

    <br>
    <br>
    <div align="center"><strong>BE AWARE, DEVELOPERS TAKE NO RESPONSIBILITY FOR DATA LOSS/CORRUPTION.</strong></div>
    <br>
    <br>

    Pick a table to export.

    <?= $this->Form->select('table', ['Tickets','Staff Assignments', 'Users']) ?>


    <?php echo $this->Html->link(
        'Export Table',
        '/admindata/export/',
        ['controller' => 'AdminData', 'action' => 'export']);
    ?>

</div>