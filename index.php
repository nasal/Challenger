<?php

session_start();

$dbconn = pg_connect("host=localhost dbname=challenge user=postgres password=p4ssw0rd")
    or die('Could not connect: ' . pg_last_error());

function user_valid($username, $password) {
    if (pg_num_rows(pg_query("select null from users where username = '" . $username . "' and password = '" . md5($password) . "'")))
        return true;
}

function user_info($username) {
    $user = pg_fetch_assoc(pg_query("select * from users where username = '" . $username . "' limit 1"));
    return $user;
}

function user_info_id($id) {
    $user = pg_fetch_assoc(pg_query("select * from users where user_id = '" . $id . "' limit 1"));
    return $user;
}

function get_category($id) {
    $cat = pg_fetch_assoc(pg_query("select name from game_type where gt_id = '" . $id . "' limit 1"));
    return $cat['name'];
}

function get_challenge($id) {
    $cat = pg_fetch_assoc(pg_query("select title from challenge where challenge_id = '" . $id . "' limit 1"));
    return $cat['title'];
}

function get_gametype_from_challenge($id) {
    $cat = pg_fetch_assoc(pg_query("select game_type from challenge where challenge_id = '" . $id . "' limit 1"));
    return $cat['game_type'];
}

$error = 0;
$success = 0;

if (isset($_POST['signin'])) {
    if (user_valid($_POST['username'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        header('location: ./');
    } else {
        $error = 1;
    }
}

if (isset($_POST['signup'])) {
    if (!pg_num_rows(pg_query("select null from users where username = '" . $_POST['username'] . "'"))) {
        pg_query("
            insert into users 
            (email, username, name, surname, city, country_code, password)
            values 
            ('" . strip_tags(pg_escape_string($_POST['email'])) . "', '" . strip_tags(pg_escape_string($_POST['username'])) . "', '" . strip_tags(pg_escape_string($_POST['name'])) . "', '" . strip_tags(pg_escape_string($_POST['surname'])) . "', '" . strip_tags(pg_escape_string($_POST['city'])) . "', '" . strip_tags(pg_escape_string($_POST['country'])) . "', '" . md5($_POST['password']) . "')
            ");
        $_SESSION['username'] = $_POST['username'];
        header('location: ./');
    } else {
        $error = 2;
        header('location: ./?user=register');
    }
}

if (isset($_POST['create_challenge'])) {
    $u = user_info($_SESSION['username']);
    pg_query("insert into challenge (created_by, title, description, game_type, date) values ('" . (int)$u['user_id'] . "', '" . strip_tags(pg_escape_string($_POST['title'])) . "', '" . strip_tags(pg_escape_string($_POST['description'])) . "', '" . strip_tags(pg_escape_string($_POST['game_type'])) . "', now())");
    header('location: ./');
}

if (isset($_POST['delete_challenge'])) {
    $f = pg_fetch_assoc(pg_query("select created_by from challenge where challenge_id = '" . (int)$_GET['id'] . "' limit 1"));
    $u = user_info_id($f['created_by']);
    if ($u['username'] == $_SESSION['username']) {
        pg_query("update challenge set status = '1' where challenge_id = '" . (int)$_GET['id'] . "'");
        header('location: ./');
    }
}

if (isset($_POST['accept_challenge'])) {
    $u = user_info($_SESSION['username']);
    pg_query("insert into participant (participant, challenge) values ('" . $u['user_id'] . "', '" . (int)$_GET['id'] . "')");
    header('location: ./?challenge=show&id=' . (int)$_GET['id']);
}

?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Welcome to Challenge.</title>
        <style>
            body { margin: 0; padding: 0; }
            a { text-decoration: none; }
            #loginPanel #uname { padding: 5px 10px; width: 92%; margin: 0 0 10px; }
            #loginPanel #passwd { padding: 5px 10px; width: 92%; margin: 5px 0; }
            #loginPanel #login { margin: 10px 0 5px; }
            #registerPanel input { padding: 5px 10px; width: 93%; }
            #registerPanel #name, #registerPanel #surname { width: 40%; }
            #registerPanel #surname { float: right; }
            #registerPanel #register { width: auto; }
            #userPanel a { color: #C7D8FF; }
            #logo a { color: orange; }
            #logo a:hover { text-decoration: none; color: darkorange; }
            .header { border-bottom: solid 1px #333; padding-bottom: 5px; margin-bottom: 20px; }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.logoHover').bind('mouseenter mouseleave', function() {
                    $(this).attr({
                        src: $(this).attr('data-other-src'), 
                        'data-other-src': $(this).attr('src')
                    })
                });
            });
        </script>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="static/css/normalize.css" type="text/css" media="screen" charset="utf-8"/>
        <link rel="stylesheet" href="static/css/flatstrap.css" type="text/css" media="screen" charset="utf-8"/>
        <link rel="stylesheet" href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" type="text/css" media="screen" charset="utf-8"/>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <header>
            <div style="background: #333 url('static/img/siva.png'); border-bottom: solid 1px #506AA6; padding: 20px 0; margin-bottom: 20px; overflow: auto; color: white;">
                <div style="margin: 0 30px;">
                    <h1 style="margin: 0; padding: 0; float: left;" id="logo">
                        <a href="./"><img src="static/img/logo.png" style="height: 50px"></a>
                    </h1>
                    <div id="createAccount" style="float: right; margin-top: 10px; line-height: 30px;">
                        <? if (isset($_SESSION['username'])): ?>
                            <a href="/user/username"><img src="https://lh4.googleusercontent.com/-ziF5YeGC4IQ/AAAAAAAAAAI/AAAAAAAAA7A/jJWj1-IO5X4/s46-c-k-no/photo.jpg" style="width: 35px; margin-right: 5px; border: none;"></a>
                            <span id="userPanel"><a href="./?user=profile&uname=<?= $_SESSION['username']; ?>"><?= $_SESSION['username']; ?></a> (<a href="./?user=logout">Logout</a></a>)</span>
                        <?php else: ?>
                            <span style="margin-right: 10px;">Need a Challenge?</span> <a href="./?user=register" class="btn btn-info">JOIN US</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>
        <div id="content" style="width: 900px; margin: 0 auto; padding: 10px 0; overflow: auto; min-height: 400px;">
            <?php
            switch(key($_REQUEST)) {
                case 'user':
                    include('user.php');
                    break;
                case 'challenge':
                    include('challenge.php');
                    break;
                default:
                    include('main.php');
            }
            ?>
        </div>
        <footer>
            <div style="background: #fff; border-top: solid 1px #eee; padding: 10px 0; font-size: 11px; margin-top: 20px;">
                <div style="margin: 0 30px;">
                    <span style="color: #aaa;">&copy; 2013 Challenge</span>
                </div>
            </div>
        </footer>
    </body>
</html>
<?
pg_close($dbconn);
?>