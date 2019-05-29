<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 11:06
 */
?>

    <table class="table table-striped table-hover tagTable">
    <?php foreach ($groups as $g): ?>
        <tr>
            <td><h8><?= $g->getTitle() ?></h8></td>
            <td><a href="index.php?controller=group&action=delete&id=<?= $g->getId() ?>">
                <i class="fas fa-trash-alt fa-large"></i></a></td>
            <td><a href="index.php?controller=group&action=edit&id=<?= $g->getId() ?>"><i class="fas fa-edit fa-large"></i></a></td>

        </tr>
    <?php endforeach; ?>
    </table>
<hr>
<?php if ($action == "add"){ ?>
<h4>Create new Group:</h4>
<?php }else{ ?>
<h4>Edit Group:</h4>
<?php } ?>
    <form action="index.php?controller=group&action=<?= $action ?>" method="post">

        <input type="hidden" name="id" value="<?= $group->getId() ?>" />

        <label for="title">Title*</label>
        <input type="text" name="title" value="<?= clean($group->getTitle(),false) ?>" maxlength="80"/>

        <h5 class="mt-5">Rechte:</h5>
        <input type="hidden" name="rightsArticle" value="0" />
        <input type="checkbox" name="rightsArticle" value="1" <?= $group->hasArticleRights() ? "checked" : "" ?> />
        <label for="rightsArticle">Artikel bearbeiten/erstellen</label>
        </br>
        <input type="hidden" name="rightsUser" value="0" />
        <input type="checkbox" name="rightsUser" value="1" <?= $group->hasUserRights() ? "checked" : "" ?> />
        <label for="rightsUser">User/Usergruppen bearbeiten/erstellen</label>
        </br>
        <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />

        <input type="submit" class="button" value="Abschicken"/>
    </form>