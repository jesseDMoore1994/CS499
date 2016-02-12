<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Staff Assignments'), ['controller' => 'StaffAssignments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff Assignment'), ['controller' => 'StaffAssignments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Middle Initial') ?></th>
            <td><?= h($user->middle_initial) ?></td>
        </tr>
        <tr>
            <th><?= __('Street') ?></th>
            <td><?= h($user->street) ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= h($user->city) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($user->state) ?></td>
        </tr>
        <tr>
            <th><?= __('Zip') ?></th>
            <td><?= h($user->zip) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone No') ?></th>
            <td><?= h($user->phone_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Created') ?></th>
            <td><?= h($user->date_created) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Modified') ?></th>
            <td><?= h($user->date_modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Is Super Admin') ?></th>
            <td><?= $user->is_super_admin ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Season Ticket') ?></th>
            <td><?= $user->season_ticket ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Staff Assignments') ?></h4>
        <?php if (!empty($user->staff_assignments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('User Id') ?></th>
                <th><?= __('Theater Id') ?></th>
                <th><?= __('Access Level') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->staff_assignments as $staffAssignments): ?>
            <tr>
                <td><?= h($staffAssignments->user_id) ?></td>
                <td><?= h($staffAssignments->theater_id) ?></td>
                <td><?= h($staffAssignments->access_level) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'StaffAssignments', 'action' => 'view', $staffAssignments->]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'StaffAssignments', 'action' => 'edit', $staffAssignments->]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StaffAssignments', 'action' => 'delete', $staffAssignments->], ['confirm' => __('Are you sure you want to delete # {0}?', $staffAssignments->)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
