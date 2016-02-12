<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ticket'), ['action' => 'edit', $ticket->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ticket'), ['action' => 'delete', $ticket->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tickets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ticket'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tickets view large-9 medium-8 columns content">
    <h3><?= h($ticket->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Show Name') ?></th>
            <td><?= h($ticket->show_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Theater') ?></th>
            <td><?= h($ticket->theater) ?></td>
        </tr>
        <tr>
            <th><?= __('Section') ?></th>
            <td><?= h($ticket->section) ?></td>
        </tr>
        <tr>
            <th><?= __('Row') ?></th>
            <td><?= h($ticket->row) ?></td>
        </tr>
        <tr>
            <th><?= __('Payment Method') ?></th>
            <td><?= h($ticket->payment_method) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ticket->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Customer Id') ?></th>
            <td><?= $this->Number->format($ticket->customer_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Seat') ?></th>
            <td><?= $this->Number->format($ticket->seat) ?></td>
        </tr>
        <tr>
            <th><?= __('Show Date') ?></th>
            <td><?= h($ticket->show_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Time') ?></th>
            <td><?= h($ticket->start_time) ?></td>
        </tr>
        <tr>
            <th><?= __('End Time') ?></th>
            <td><?= h($ticket->end_time) ?></td>
        </tr>
        <tr>
            <th><?= __('Accessible Seat') ?></th>
            <td><?= $ticket->accessible_seat ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Paid') ?></th>
            <td><?= $ticket->paid ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
