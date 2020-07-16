<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit or Delete Job Application</title>

<?php if (!empty($errors)): ?>
    <?php $errorMessage = implode($errors); ?>
    <p class="important"><?= $errorMessage ?></p>
<?php endif; ?>

<form action="<?= BASE_URL . $formAction ?>" method="post">
<div id="oddaja_vloge">
        <fieldset>
            <h2>ODDAJA VLOGE</h2>
            <div class="spremni_text">Popravite spodnja polja in oddajte vlogo. Ali zbrišete vlogo.
            </div><br>
            <input type="hidden" id="id" name="id" value="<?= $data["id"] ?>" />
            <input type="hidden" name="token" value="<?=$_SESSION['token']?>" />
			<input id="first" name="first" type="text" placeholder="Ime" minlength="3" maxlength="50" required value="<?= $data["first"] ?>" autofocus /><br /><br />

			<input id="last" name="last" type="text" placeholder="Priimek" minlength="3" maxlength="70" required value="<?= $data["last"] ?>" /><br /><br />
            
            <input id="title" name="title" type="text" placeholder="Naslov" minlength="5" maxlength="70" required value="<?= $data["title"] ?>" /><br /><br />

            <textarea id="opis_vloge" name= "opis_vloge" rows="4" cols="50" minlength="10" maxlength="400" required><?= empty($data["opis_vloge"]) ? "Zakaj ste vi najbolj primerni za izbrano delo?" : $data["opis_vloge"] ?></textarea><br /><br />

            <button id="addButton" class="wide_buttn">ODDAJ SPREMENJENO</button><br /><br />
        </fieldset><br />
    </div>
</form>
<form action="<?= BASE_URL . "jobs/delete" ?>" method="get">
<div id="oddaja_vloge">
    <fieldset>
    <input type="hidden" name="id" value="<?= $data["id"] ?>"  />
    <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
    <label style="color:#207cca">Delete? <input type="checkbox" name="delete_confirmation" title="Are you sure you want to delete this entry?" required /></label>
    <button class="important">Delete record</button>
    </fieldset><br />
    <?php $pageno_str = empty($_SESSION['pageno']) ? "" : "?pageno=".$_SESSION['pageno'] ?>
    <a href="<?= BASE_URL . "jobs".$pageno_str?>" class="admin_link">Nazaj na seznam vlog.</a>
</div>
</form>