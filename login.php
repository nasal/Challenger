<div id="loginContent" style="width: 520px; float: left;">
    <img src="static/img/naslovna_slika20x10cm.jpg" width="100%" style="margin-top: 30px;">
</div>
<div id="loginPanel" style="padding: 10px 30px 20px; float: right; width: 280px;">
    <?php if ($error == 1): ?>
        <div class="alert">Login error!</div>
    <?php endif; ?>
    <?php if ($success == 1): ?>
        <div class="alert alert-success">Registration successful.</div>
    <?php endif; ?>
    <form method="post" style="margin-bottom: 10px;">
        <input type="text" name="username" id="uname" placeholder="Username"><br>
        <input type="password" name="password" id="passwd" placeholder="Password"><br>
        <input type="submit" id="login" class="btn btn-primary" name="signin" value="Sign in">
    </form>
    <a href="#">Forgot your password?</a>
    <h4>New here?</h4>
    <p style="margin: 10px 0;">
        - <em>Have a hard time finding competition?</em><br>
        - <em>Looking for teammates to create a team?</em><br>
        - <em>Simply want to have some fun?</em>
    </p>
    <p style="text-align: justify;">If you your answer was YES to at least one of these questions, you should <a href="./?user=register">sign up</a> now!</p>
</div>