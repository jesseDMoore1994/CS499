<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Staff Assignment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="staffAssignments index large-9 medium-8 columns content">
    <h3><?= __('Staff Assignments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('theater_id') ?></th>
                <th><?= $this->Paginator->sort('access_level') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffAssignments as $staffAssignment): ?>
            <tr>
                <td><?= $staffAssignment->has('user') ? $this->Html->link($staffAssignment->user->id, ['controller' => 'Users', 'action' => 'view', $staffAssignment->user->id]) : '' ?></td>
                <td><?= $this->Number->format($staffAssignment->theater_id) ?></td>
                <td><?= $this->Number->format($staffAssignment->access_level) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $staffAssignment->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $staffAssignment->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $staffAssignment->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $staffAssignment->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
