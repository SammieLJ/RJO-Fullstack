<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Logged-in</title>

<h1 style="color:#ddd">Successfull log-in</h1>

<?php include("view/menu-links.php"); ?>

<?php $backAddress = "logged" //str_replace(BASE_URL ,"" ,$_SERVER["REQUEST_URI"]) ?>
<?php $_SESSION['backAddress'] = $backAddress?>

<p>Welcome <b><?= $username ?></b>. Your provided a valid username and password.</p>