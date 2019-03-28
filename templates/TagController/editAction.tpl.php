<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 11:06
 */
?>

    <table class="table table-striped table-hover tagTable">
    <?php foreach ($tags as $tag1): ?>
        <tr>
            <td><h8><?= $tag1->getTitle() ?></h8></td>
            <td><a href="index.php?controller=tag&action=delete&id=<?= $tag1->getId() ?>">
                <i class="fas fa-trash-alt fa-large"></i></a></td>
            <td><a href="index.php?controller=tag&action=edit&id=<?= $tag1->getId() ?>"><i class="fas fa-edit fa-large"></i></a></td>

        </tr>
    <?php endforeach; ?>
    </table>
<hr>
<?php if ($action == "add"){ ?>
<h4>Create new Tag:</h4>
<?php }else{ ?>
<h4>Edit Tag:</h4>
<?php } ?>
    <form action="index.php?controller=tag&action=<?= $action ?>" method="post">

        <input type="hidden" name="id" value="<?= $tag->getId() ?>" />

        <label for="title">Title*</label>
        <input type="text" name="title" value="<?= clean($tag->getTitle(),false) ?>" maxlength="80"/>
        <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />

        <input type="submit" class="button" value="Abschicken"/>
    </form>