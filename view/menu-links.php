<p>[
<a href="<?= BASE_URL . "jobs" ?>">Vse vloge</a> | 
<a href="<?= BASE_URL . "jobs/add" ?>">Dodaj vlogo</a>

<?php if (User::isLoggedIn()): ?>
	| <a href="<?= BASE_URL . "logout" ?>">Logout (<?= User::getUsername() ?>)</a>
<?php else: ?>
	| <a href="<?= BASE_URL . "login" ?>">Login (secure)</a>
<?php endif; ?>

]</p>
