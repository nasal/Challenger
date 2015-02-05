<style>
    #userActivities ul { list-style: none; padding: 0; margin: 0; }
    #userActivities a { display: block; border-bottom: solid 1px #ddd; padding: 5px 10px; }
</style>
<?php
if (isset($_GET['uname'])) {
    $p = user_info($_GET['uname']);
} 
else {
    $p = user_info($_SESSION['username']);
}
?>
<div style="overflow: hidden;">
    <div style="width: 30%; float: left;" id="userLeft">
        <img src="http://www.american.edu/uploads/profiles/large/chris_palmer_profile_11.jpg" width="100%">
        <img src="static/img/radar_chart.png" style="margin-top: 10px;">
    </div>
    <div style="width: 67%; float: right;" id="userRight">
        <h1 class="header"><?= ucwords($p['name']) . ' ' . ucwords($p['surname']); ?></h1>
        <div id="userInfo">
            <span style="width: 120px; display: inline-block;">City:</span> <?= ucwords($p['city']); ?><br>
            <span style="width: 120px; display: inline-block;">Country:</span> <?= ucwords($p['country_code']); ?><br>
            <span style="width: 120px; display: inline-block;">Last activity:</span> 3 hours ago
        </div>
        <!--
        <h2>Ranking</h2>
        <strong>#1</strong> težak in Slovenia<br>
        <strong>#6</strong> težak in Europe<br>
        <strong>#15</strong> težak worldwide
        -->
        <h2>Latest challenges</h2>
        <div id="userActivities" style="margin-top: 10px; border: solid 1px #ddd; border-bottom: none;">
            <ul>
                <?php
                $q = pg_query("select * from challenge where created_by = '" . $p['user_id'] . "' and status != '1'");
                $a = pg_query("select * from participant where participant = '" . $p['user_id'] . "'");
                while ($f = pg_fetch_assoc($q)) {
                    echo '<li><a href="./?challenge=show&id=' . $f['challenge_id'] . '">' . $f['title'] . ' (' . get_category($f['game_type']) .')</a></li>';
                }
                while ($fa = pg_fetch_assoc($a)) {
                    echo '<li><a href="./?challenge=show&id=' . $fa['challenge'] . '">' . get_challenge($fa['challenge']) . ' (' . get_category(get_gametype_from_challenge($fa['challenge'])) .')</a></li>';
                }
                
                ?>
            </ul>
        </div>
    </div>
</div>