<!DOCTYPE html>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "StarRating.css" ?>">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "ionicons.min.css" ?>">

<?php 
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
?>
<?php $backAddress = str_replace(BASE_URL ,"" ,$_SERVER["REQUEST_URI"]) ?>
<?php $_SESSION['backAddress'] = $backAddress?>
<title>List of Job Application</title>
<h2>Pregled vlog</h2>
<body>    
    <div id="pregled_vlog_admin">
    <?php include("view/menu-links.php"); ?>
    <?php foreach ($jobapps as $jobapp): ?>
        <div id="vloga_container" class="cloner">
            <input type="hidden" id="<?= $jobapp["id"] ?>" name="Id" value="<?= $jobapp["id"] ?>">
            <span class="span_label" id="label_vloga_ime" style="position: absolute;top: 7%;left: 2%;">Ime</span>
            <div id="vloga_ime"><?= $jobapp["first_name"] ?>
            </div>
            <span class="span_label" id="label_vloga_priimek" style="position: absolute;top: 7%;left: 17%;">Priimek</span>
            <div id="vloga_priimek"><?= $jobapp["last_name"] ?>
            </div>
            <span class="span_label" id="label_vloga_naslov" style="position: absolute;top: 7%;left: 32%;">Naslov</span>
            <div id="vloga_naslov"><?= $jobapp["job_title"] ?>
            </div>
            <span class="span_label" id="label_rating" style="position: absolute;top:53%;left: 2%;">Oceni vlogo:</span>
            <x-star-rating value="<?= $jobapp["star_rate"] ?>" number="5" id="rating<?= $jobapp["id"] ?>" style="left:16%;top: 49%;"><?= $jobapp["star_rate"] ?></x-star-rating>
            <span class="span_label" id="label_vloga_opis" style="position: absolute;top: 7%;left: 60%;">Opis</span>
            <div id="vloga_opis"><?= $jobapp["job_text"] ?></div>       
            <span class="span_label" id="label_vloga_datum" style="position: absolute;top:80%;left:2%;">Datum <?= date( "d.m.Y", strtotime($jobapp["job_date"])) ?></span>
            <span class="span_label" id="label_edit_link" style="position: absolute;top:80%;left:16%;"><a href="<?= BASE_URL . "jobs/edit" ?>?editID=<?= $jobapp["id"] ?>" id="editLink<?= $jobapp["id"] ?>" data-id="<?= $jobapp["id"] ?>">Edit/Delete</a></span>
        </div><br />
        <?php if(User::isAdmin()): ?>
        <script type="text/javascript">
            rating<?= $jobapp["id"] ?>.addEventListener('rate', () => {
                console.log("Rating<?= $jobapp["id"] ?>: " + rating<?= $jobapp["id"] ?>.value);
                $.get("<?= BASE_URL . "api/starate/update" ?>", 
                    {ID : $("#rating<?= $jobapp["id"] ?>").prop("id"), ratingValue : $("#rating<?= $jobapp["id"] ?>").val()})
            });
        </script>
        <?php endif ?>
    <?php endforeach; ?>
    <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
    </div><br><br>
        

 

    <script src="<?= JS_URL . "jquery-3.3.1.min.js" ?>"></script>
    <script src="<?= JS_URL . "scripts.js" ?>"></script>
    
    <footer></footer>
    
    <script src="<?= JS_URL . "StarRating.js" ?>"></script>
    <script src="<?= JS_URL . "bootstrap.min.js" ?>"></script>
    
</body>