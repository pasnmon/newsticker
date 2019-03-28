<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 19.03.19
 * Time: 07:53
 */
?>
<form action="index.php?action=<?= $action ?>" method="post">

    <input type="hidden" name="id" value="<?= $article->getId() ?>" />

    <label for="title">Title*</label>
    <input type="text" name="title" value="<?= clean($article->getTitle(),false) ?>" maxlength="80"/>

    <label for="teaser">Teaser*</label>
    <input type="text" name="teaser" id="teaser" value="<?= clean($article->getTeaser(),false) ?>"/>

    <label for="news">News*</label>
    <textarea name="news" id="news"><?= clean($article->getNews()) ?></textarea>

    <label for="tags">Tags*</label></br>
    <select name="tag_ids[]" id="tags" multiple="multiple">
        <?php foreach ($tags as $tag): ?>
        <option value="<?= $tag->getId() ?>" <?= ($article->hasTag($tag) ? "selected" :"") ?>>
            <?= $tag ?>
        </option>
        <?php endforeach;?>
    </select></br>

    <label for="published_at">PublishedAt</label>
    <input type="text" name="published_at" id="published_at" value="<?= $article->getPublishedAt()->format('Y-m-d H:i:s') ?>"/>

    <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />

    <input type="submit" class="button" value="Abschicken"/>
</form>
