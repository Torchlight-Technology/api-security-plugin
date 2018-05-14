<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $endPoint
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $endPoint->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $endPoint->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List End Points'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="endPoints form large-9 medium-8 columns content">
    <?= $this->Form->create($endPoint) ?>
    <fieldset>
        <legend><?= __('Edit End Point') ?></legend>
        <?php
            echo $this->Form->control('controller');
            echo $this->Form->control('method');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
