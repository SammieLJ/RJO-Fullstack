<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add new Job Application</title>

<?php if (!empty($errorMessage)): ?>
    <p class="important"><?= $errorMessage ?></p>
<?php endif; ?>

<div id="vloga_oddana">
    <fieldset>
        <img src="<?= SVG_URL ?>blue-tick-inside-circle.svg" alt="checkmark circle" style="width: 128px;height: 128px;">
        <h2>VLOGA USPEŠNA ODDANA</h2>
        <div class="spremni_text">Vaša vloga je bila oddana v preverjanje.<br />
            Po pregledu Vas bodo naši uslužbenci<br />
            o rezultatu vas obvestimo preko elektronske pošte,<br />
            ki je navedena v našem uporabniškem profilu.
        </div><br /><br />
        <button id="addNewApplication" onClick="redirect()" class="wide_buttn">NOVA ODDAJA</button><br /><br />
    </fieldset><br />
    <?php $backAdr_str = empty($_SESSION['backAddress']) ? "" : $_SESSION['backAddress'] ?>
    <a href="<?= BASE_URL . $backAdr_str?>" class="admin_link">Nazaj na izhodno stran.</a>
</div>
<script src="<?= JS_URL . "jquery-3.3.1.min.js" ?>"></script>
<script type="text/javascript">
    function redirect()
    {
        $(location).attr('href','<?= BASE_URL . "jobs/add" ?>');
    }
</script>