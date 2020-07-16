<!DOCTYPE html>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "StarRating.css" ?>">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "ionicons.min.css" ?>">

<title>List of Job Application</title>
<h2>Pregled vlog</h2>
<body>    
    <div id="pregled_vlog_admin">
        <?php include("view/menu-links.php"); ?>
        <br><br><br>
        <div id="ni_objavljenih_vlog"><h1 style="text-align: center;color:#207cca">Ni objavljene nobene vloge!</h1></div>
        <br><br><br>
    </div>      

    <script src="<?= JS_URL . "jquery-3.3.1.min.js" ?>"></script>
    <script src="<?= JS_URL . "scripts.js" ?>"></script>
    
    <footer></footer>
    
    <script src="<?= JS_URL . "StarRating.js" ?>"></script>
    <script src="<?= JS_URL . "bootstrap.min.js" ?>"></script>
    
</body>