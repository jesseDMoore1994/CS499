<div class="admin-page">
    <div class="admin-page-top">

        <div class="admin-page-tabs">
            <?= $this->element("admin/setup") ?>
        </div>

    </div>
    <div class="admin-top-border"></div>

    <?= $this->Element("admin/form_account") ?>

    <br>
    <br>
    <div align="center"><strong>BE AWARE, DEVELOPERS TAKE NO RESPONSIBILITY FOR DATA LOSS/CORRUPTION.</strong></div>
    <br>
    <br>

    <?php
    echo $this->Form->create();
    echo "Pick a table to export.";
    echo $this->Form->select('table', ['Tickets','Staff Assignments','Users','Theaters','Sections','Seats','Seasons','Rows',
        'Plays','Performances','Cart Items']);

    echo $this->Form->submit('export', array('class'=>'button'));

    echo $this->Form->end();
    ?>

</div>