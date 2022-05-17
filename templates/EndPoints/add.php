<?php
use Cake\View\View;

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $endPoint
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List End Points'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="endPoints form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <?php foreach($resources as $controller => $methods): ?>
    <fieldset>
        <legend><?= $controller; ?></legend>
        <?php
            foreach($methods as $methodName) {
                $checked = false;
                if(isset($endPoints[$controller][$methodName])) {
                    $checked = true;
                }

                echo $this->Form->control('methods['.$controller.']['.$methodName.']',
                    [
                        'type' => 'checkbox',
                        'label' => $methodName,
                        'value' => 1,
                        'checked' => $checked
                    ]
                );
            }
        ?>
    </fieldset>
    <?php endforeach;?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
