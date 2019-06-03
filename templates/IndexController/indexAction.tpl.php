
<?php if($action == "search" && !empty($like)): ?>
<p>
    Sie suchten nach:
    &raquo;<?= $like ?>&laquo;
</p>
<?php endif; ?>
<?php if(!empty($tag)): ?>
    <p>
        Sie suchten nach dem Tag:
        &raquo;<?= $tag->getTitle() ?>&laquo;
    </p>
<?php endif; ?>

<?php foreach ($articles as $article): ?>
    <div class="jumbotron">
    <article>
        <header>
            <h2><?= $article->getTitle() ?></h2>
        </header>

        <div class="teaser">
            <?= $article->getTeaser() ?>
        </div>

        <div class="links">
            <a href="index.php?action=read&id=<?= $article->getId() ?>"><i class="fas fa-info fa-2x"></i></a>
            <?php if (isLoggedIn() && $articleRights): ?>
            <a href="index.php?action=edit&id=<?= $article->getId() ?>"><i class="fas fa-edit fa-2x"></i></a>
            <a href="index.php?action=delete&id=<?= $article->getId() ?>"><i class="fas fa-trash-alt fa-2x"></i></a>
            <?php endif; ?>
        </div>
        <?php require "templates/articleFooter.tpl.php"?>
    </article>
    </div>
 <?php endforeach; ?>