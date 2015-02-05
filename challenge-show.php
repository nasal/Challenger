<?php
$q = pg_query("select * from challenge where challenge_id = '" . (int)$_GET['id'] . "' limit 1");
if (pg_num_rows($q)) {
	$f = pg_fetch_assoc($q);
	$u = user_info_id($f['created_by']);
	echo '<h1 class="header">' . $f['title'] . '</h1>';
	?>
	<h3>A challenge by <a href="./?user=profile&uname=<?= $u['username']; ?>"><?= $u['name'] . ' ' . $u['surname']; ?></a>.</h3>
	<div class="row-fluid"><div class="span1">Added:</div><div class="span11"> <?= $f['date']; ?></div></div>
	<div class="row-fluid"><div class="span1">Category:</div><div class="span11"><?= get_category($f['game_type']); ?></div></div>
	<p style="margin: 10px 0;"><?= nl2br($f['description']); ?></p>
	<?php
	$n = pg_query("select * from participant where challenge = '" . (int)$_GET['id'] . "'");
	if (pg_num_rows($n)) {
		echo '<h2>Participants</h2><p>';
		while ($fn = pg_fetch_assoc($n)) {
			$p = user_info_id($fn['participant']);
			echo '<a href="./?user=profile&uname=' . $p['username'] . '">' . ucwords($p['name']) . ' ' . ucwords($p['surname']) . '</a><br>';
		}
		echo '</p>';
	}
	if ($u['username'] == $_SESSION['username']) {
		echo '<form method="post"><input type="submit" value="Delete challenge" name="delete_challenge" class="btn btn-danger" onclick="return confirm(\'Are you sure?\');"></form>';
	}
	else {
		$me = user_info($_SESSION['username']);
		if (!pg_num_rows(pg_query("select null from participant where participant = '" . $me['user_id'] . "' and challenge = '" . (int)$_GET['id'] . "'"))) {
			echo '<form method="post"><input type="submit" value="Accept challenge" name="accept_challenge" class="btn btn-success"></form>';	
		}
	}
} else {
	echo '<h1>There is no such Challenge.</h1><h2>Go <a href="./">home</a>.</h2>';
}
?>