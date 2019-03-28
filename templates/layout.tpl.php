<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Newsticker</title>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/stylesheet.css" />
    <link type="text/css" rel="stylesheet" href="css/register.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.7.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/active.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <?php require 'navi.tpl.php'; ?>
    <?php require 'flash_message.tpl.php'; ?>
    <?php require 'errors.tpl.php'; ?>

    <section>
        <?php require $template; ?>
    </section>
</body>
</html>