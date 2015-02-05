<?php
$q = pg_query("select * from challenge where game_type = '" . (int)$_GET['id'] . "' and status != '1'");
echo '<h1 class="header">' . get_category($_GET['id']) . '</h1>';
while ($f = pg_fetch_assoc($q)) {
	$u = user_info_id($f['created_by']);
    echo '<a href="./?challenge=show&id=' . $f['challenge_id'] . '">' . $u['name'] . ' ' . $u['surname'] . ' - ' . $f['title'] . '</a><br>';
}
?>