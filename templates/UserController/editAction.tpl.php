<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 20.03.19
 * Time: 14:14
 */
?>

<div id="container">
<form action="index.php?controller=user&action=<?= $action ?>" method="post">
    <ul>
        <input type="hidden" id="id" name="id" value="<?= $user->getId() ?>"/>
        <li>
            <label for="email">Email:*</label>
            <span><input type="text" id="email" name="email" value="<?= clean($user->getEmail(),false) ?>"/></span>
        </li>
        <li>
            <label for="displayName">Displayname:*</label>
            <span><input type="text" id="displayName" name="displayName" value="<?= clean($user->getDisplayName(),false) ?>"/></span>
        </li>
        <li>
            <label for="password">Password:*</label>
            <span><input type="password" id="password" name="password"/></span>
        </li>
        <?php if($action == "edit"): ?>
        <li>
            <label for="userGroup">Berechtigung:*</label>
            <span><select id="userGroup" name="userGroup">
                    <?php foreach ($userGroups as $group): ?>
                    <option value="<?= $group->getId() ?>"
                        <?php if ($user->getUserGroupId() == $group->getId()): ?>
                        selected
                        <?php endif; ?>
                    ><?= $group ?></option>
                    <?php endforeach; ?>
                </select></span>
        </li>
        <?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= clean($token, false) ?>" />
        <li>
            <input type="submit" class="btn btn-success" value="Senden" />
        </li>
    </ul>
</form>
    <div id="pswd_info">
        <h4>Password must meet the following requirements:</h4>
        <ul>
            <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
            <li id="lower" class="invalid">At least <strong>one lowercase letter</strong></li>
            <li id="number" class="invalid">At least <strong>one number</strong></li>
            <li id="special" class="invalid">At least <strong>one special character</strong></li>
            <li id="length" class="invalid">Be at least <strong>12 characters</strong></li>
        </ul>
    </div>
</div>