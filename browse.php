<style>
    #yourActivities img { margin-right: 25px; margin-bottom: 25px; width: 150px; border: 0; }
    #suggestedPicks img { width: 50px; height: 50px; margin-right: 10px; margin-bottom: 10px; border: 0; }
</style>
<h1 class="header">Your activities</h1>
<div id="yourActivities">
    <?php
    $u = user_info($_SESSION['username']);
    $q = pg_query("select distinct challenge_id from challenge where created_by = '" . $u['user_id'] . "'");
    $p = pg_query("select distinct challenge from participant where participant = '" . $u['user_id'] . "'");
    $act = array();

    if (pg_num_rows($q) || pg_num_rows($p)) {
        while ($f = pg_fetch_assoc($q)) {
            if (!in_array(get_gametype_from_challenge($f['challenge_id']), $act)) {
                echo '<a href="./?challenge=category&id=' . get_gametype_from_challenge($f['challenge_id']) . '"><img src="static/img/logo' . get_gametype_from_challenge($f['challenge_id']) . '.jpg" data-other-src="static/img/logo' . get_gametype_from_challenge($f['challenge_id']) . '_hover.jpg" class="logoHover"></a>';
                array_push($act, get_gametype_from_challenge($f['challenge_id']));
            }
        }
        while ($fp = pg_fetch_assoc($p)) {
            if (!in_array(get_gametype_from_challenge($fp['challenge']), $act)) {
                echo '<a href="./?challenge=category&id=' . get_gametype_from_challenge($fp['challenge']) . '"><img src="static/img/logo' . get_gametype_from_challenge($fp['challenge']) . '.jpg" data-other-src="static/img/logo' . get_gametype_from_challenge($fp['challenge']) . '_hover.jpg" class="logoHover"></a>';
                array_push($act, get_gametype_from_challenge($fp['challenge']));
            }
        }
    } else {
        echo 'You haven\'t been active yet';
    }
    ?>
</div>

<h2 class="header">Suggested picks</h2>
<div id="suggestedPicks">
    <a href="./?challenge=category&id=1"><img src="static/img/logo1.jpg" data-other-src="static/img/logo1_hover.jpg" class="logoHover"></a>
    <a href="./?challenge=category&id=2"><img src="static/img/logo2.jpg" data-other-src="static/img/logo2_hover.jpg" class="logoHover"></a>
    <a href="./?challenge=category&id=3"><img src="static/img/logo3.jpg" data-other-src="static/img/logo3_hover.jpg" class="logoHover"></a>
    <a href="./?challenge=category&id=4"><img src="static/img/logo4.jpg" data-other-src="static/img/logo4_hover.jpg" class="logoHover"></a>
</div>

<h2 class="header">
    Recent challenges
    <span style="float: right;">
        <a href="./?challenge=create">+ create challenge</a>
    </span>
</h2>
<div id="recentChallenges">
    <?php
    $q = pg_query("select * from challenge where status != '1' order by challenge_id desc");
    while ($f = pg_fetch_assoc($q)) {
        $u = user_info_id($f['created_by']);
        echo '<a href="./?challenge=show&id=' . $f['challenge_id'] . '">' . $u['name'] . ' ' . $u['surname'] . ' - ' . $f['title'] . '</a><br>';
    }
    ?>
</div>