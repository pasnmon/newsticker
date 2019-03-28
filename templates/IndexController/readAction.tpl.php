<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 07:37
 */
?>
<div class="jumbotron">
    <article>
        <header>
            <h4><?= $article->getTitle() ?></h4>
        </header>

        <div class="text">
            <p><?= $article->getNews() ?></p>
        </div>

        <?php if (isLoggedIn() && getGroupId($em) == 1): ?>
        <div class="links">
            <a href="index.php?action=edit&id=<?= $article->getId() ?>"><i class="fas fa-edit fa-2x"></i></a>
            <a href="index.php?action=delete&id=<?= $article->getId() ?>"><i class="fas fa-trash-alt fa-2x"></i></a>
        </div>
        <?php endif; ?>
        <?php require_once "templates/articleFooter.tpl.php"?>
    </article>
</div>