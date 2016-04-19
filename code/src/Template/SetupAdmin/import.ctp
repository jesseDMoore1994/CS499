<div class="admin-page">
	<div class="admin-page-top">

		<div class="admin-page-tabs">
			<?= $this->element("admin/setup") ?>
		</div>

	</div>
	<div class="admin-top-border"></div>

	<div class="responsive-inner">
        <br>
        <div align="center"><strong>BE AWARE, DEVELOPERS TAKE NO RESPONSIBILITY FOR DATA LOSS/CORRUPTION.</strong></div>
        <br>

        <?php
        echo $this->Form->create('', ['enctype' => 'multipart/form-data']);
            echo "Pick a table to Import.";
            echo $this->Form->select('table', ['Tickets','Staff Assignments','Users','Theaters','Sections','Seats','Seasons','Rows',
                                                'Plays','Performances','Cart Items']);

            echo $file_status;

            echo $this->Form->input('submissionFile', ['type' => 'file']);

            echo $this->Form->submit('import', array('class'=>'button'));

        echo $this->Form->end();
        ?>
	</div>

</div>