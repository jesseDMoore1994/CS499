<div class="admin-page">
    <div class="admin-results-title responsive">
    <?= $this->element("admin/top",[
        "title" => "Import / Export",
        "description" => "Page for Import of Database Information."
    ]) ?>

                <?= $this->element("admin/data/importExportLinks",[
                ]) ?>



    </div>

    <br>
    <br>
    <div align="center"><strong>BE AWARE, DEVELOPERS TAKE NO RESPONSIBILITY FOR DATA LOSS/CORRUPTION.</strong></div>
    <br>
    <br>

    <?php
    echo $this->Form->create();
        echo "Pick a table to Import.";
        echo $this->Form->select('table', ['Tickets','Staff Assignments', 'Users']);
        echo "Pick which fields to Import.";
        echo $this->Form->select('fields', ['all']);
        echo "Pick file format.";
        echo $this->Form->select('format', ['.csv']);

        echo $file_status;

        echo $this->Form->input('submissionFile', ['type' => 'file']);

        echo $this->Form->submit('import', array('class'=>'button'));

    echo $this->Form->end();
    ?>

</div>