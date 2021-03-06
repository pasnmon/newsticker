<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 07:40
 */
$tags = $article->getTags();
?>
<footer>
    Erstellt am
    <time datetime="<?= $article->getCreatedAt()->format('Y-m-d') ?>">
        <?= $article->getCreatedAt()->format('d.m.Y') ?>
    </time>
    von <?= $article->getUser() ?>
    <br />
    Tags:
    <?php foreach ($tags as $key => $tag): ?>

        <a href="index.php?controller=tag&amp;action=read&amp;id=<?= $tag->getId() ?>">
            <?= $tag ?>
        </a>
        <?= ($key == count($tags)-1) ? "" : "," ?>

    <?php endforeach; ?>
</footer>
