<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tickets'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="tickets form large-9 medium-8 columns content">
    <?= $this->Form->create($ticket) ?>
    <fieldset>
        <legend><?= __('Add Ticket') ?></legend>
        <?php
            echo $this->Form->input('customer_id');
            echo $this->Form->input('show_name');
            echo $this->Form->input('show_date');
            echo $this->Form->input('start_time');
            echo $this->Form->input('end_time');
            echo $this->Form->input('theater');
            echo $this->Form->input('section');
            echo $this->Form->input('row');
            echo $this->Form->input('seat');
            echo $this->Form->input('accessible_seat');
            echo $this->Form->input('paid');
            echo $this->Form->input('payment_method');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
