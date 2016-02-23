<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $staffAssignment->user_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $staffAssignment->user_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Staff Assignments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="staffAssignments form large-9 medium-8 columns content">
    <?= $this->Form->create($staffAssignment) ?>
    <fieldset>
        <legend><?= __('Edit Staff Assignment') ?></legend>
        <?php
            echo $this->Form->input('theater_id');
            echo $this->Form->input('access_level');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
