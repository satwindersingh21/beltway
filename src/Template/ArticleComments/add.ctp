<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ArticleComment $articleComment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Article Comments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articleComments form large-9 medium-8 columns content">
    <?= $this->Form->create($articleComment) ?>
    <fieldset>
        <legend><?= __('Add Article Comment') ?></legend>
        <?php
            echo $this->Form->control('comment');
            echo $this->Form->control('article_id', ['options' => $articles]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
