<nav class="navbar navbar-expand-lg bg-dark sticky-top">
        <button class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse navbar" id="collapsibleNavbar">
            <ul id="mainmenu" class="nav navbar-nav">
                <?php if (isLoggedIn()): ?>
                <li class="nav-item <?= ($controller == "IndexController" && ($action == "index" || $action == "read" || $action == "search"))? "active":""?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php endif; ?>
                <?php if (isLoggedIn() && getGroupId($em) == 1){ ?>
                <li class="nav-item <?= ($controller == "IndexController" && $action != "index" && $action != "read" && $action != "search")? "active":""?>">
                    <a class="nav-link" href="index.php?action=add">Create Article</a>
                </li>
                <li class="nav-item <?= ($controller == "TagController")? "active":""?>">
                    <a class="nav-link" href="index.php?controller=tag&action=add">Create Tag</a>
                </li>
                <li class="nav-item <?= ($controller == "UserController" && $action != "editUser")? "active":""?>">
                    <a class="nav-link" href="index.php?controller=user&action=show">Users</a>
                </li>
                <?php }elseif(!isLoggedIn()){ ?>
                <li class="nav-item <?= ($action == "login")? "active":""?>">
                    <a class="nav-link" href="index.php?controller=user&action=login">Login</a>
                </li>
                <li class="nav-item <?= ($action == "register")? "active":""?>">
                    <a class="nav-link" href="index.php?controller=user&action=register">Registrieren</a>
                </li>
                <?php } ?>
                <?php if (isLoggedIn()): ?>
                <li class="nav-item <?= ($controller == "UserController" && $action == "editUser")? "active":""?>">
                    <a class="nav-link" href="index.php?controller=user&action=editUser">Edit Profile</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php if (($action == "index" || $action == "search") && ((isset($_GET["controller"]) && $_GET["controller"] != "user" ) || !isset($_GET["controller"]))): ?>
        <form class="navbar-form navbar-right" action="index.php" id="search" method="get">
            <div class="input-group no-flex">
                <input type="hidden" name="action" value="search" />
                <input type="text" class="form-control" name="searchField" id="searchField" placeholder="Search" <?php if (!empty($like)) : ?>
                    value="<?= $like ?>"
                <?php endif; ?>>
                <div class="input-group-btn">
                    <button class="input-group-btn btn btn-default" type="submit">
                        <i class="fas fa-search fa-w"></i>
                    </button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</nav>