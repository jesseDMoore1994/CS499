<div class="admin-page">
    <div class="admin-results-title responsive">

                <?= $this->element("admin/data/importExportLinks",[
                ]) ?>

        <div class="responsive-inner">
            <br>
            <div align="center"><strong>BE AWARE, THIS TOOL MAY RESULT IN DATA LOSS OR CORRUPTION.</strong></div>
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
</div>
</div>