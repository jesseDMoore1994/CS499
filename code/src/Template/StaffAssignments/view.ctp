<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Staff Assignment'), ['action' => 'edit', $staffAssignment->user_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Staff Assignment'), ['action' => 'delete', $staffAssignment->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $staffAssignment->user_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Staff Assignments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff Assignment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="staffAssignments view large-9 medium-8 columns content">
    <h3><?= h($staffAssignment->user_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $staffAssignment->has('user') ? $this->Html->link($staffAssignment->user->id, ['controller' => 'Users', 'action' => 'view', $staffAssignment->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Theater Id') ?></th>
            <td><?= $this->Number->format($staffAssignment->theater_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Access Level') ?></th>
            <td><?= $staffAssignment->access_level ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
