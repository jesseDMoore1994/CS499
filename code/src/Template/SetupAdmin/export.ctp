<div class="admin-page">
    <div class="admin-page-top">

        <div class="admin-page-tabs">
            <?= $this->element("admin/setup") ?>
        </div>

    </div>
    <div class="admin-top-border"></div>

    <div class="responsive-inner">
        <br>
        <div align="center"><strong>BE AWARE, USING THIS TOOL MAY RESULT IN DATA LOSS/CORRUPTION.</strong></div>
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

</div>