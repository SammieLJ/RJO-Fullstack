<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login form</title>

<?php if (!empty($errorMessage)): ?>
    <p class="important"><?= $errorMessage ?></p>
<?php endif; ?>

<form action="<?= BASE_URL . $formAction ?>" method="post">
    <div id="prijava_admina">
        <fieldset>
            <h2>PRIJAVA</h2>
            <div class="spremni_text">Vpišite vaše uporabniško ime in geslo</div><br /><br />
			<input id="admin_upor_ime" type="text" name="username" placeholder="Uporabniško ime" autocomplete="off" 
            required autofocus /><br /><br />

			<input id="admin_upor_geslo" type="password" placeholder="Geslo" name="password" required /><br /><br />

            <button id="addAdminLogin" class="wide_buttn" autofocus>PRIJAVA</button><br /><br />
        </fieldset>
    </div>
    <div>Nimaš uporabniškega računa?&nbsp;<a href="<?= BASE_URL . "register" ?>" class="admin_link">Registriraj se tukaj.</a></div>
</form>