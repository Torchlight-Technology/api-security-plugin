<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $endPoint
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit End Point'), ['action' => 'edit', $endPoint->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete End Point'), ['action' => 'delete', $endPoint->id], ['confirm' => __('Are you sure you want to delete # {0}?', $endPoint->id)]) ?> </li>
        <li><?= $this->Html->link(__('List End Points'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New End Point'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="endPoints view large-9 medium-8 columns content">
    <h3><?= h($endPoint->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Controller') ?></th>
            <td><?= h($endPoint->controller) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Method') ?></th>
            <td><?= h($endPoint->method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($endPoint->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($endPoint->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($endPoint->modified) ?></td>
        </tr>
    </table>
</div>
