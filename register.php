<div id="registerContent" style="width: 500px; float: left;">
    <h1>Why sign up?</h1>
    <ul>
        <li>friendly an helpful community</li>
        <li>to learn and improve your game </li>
        <li>you will finnd opponents anywhere everywhere</li>
        <li>it is free! </li>
    </ul>
    <h2>Challenge</h2>
    <ul>
        <li>is a challenge finder for your favourite bar games</li>
        <li>we use advanced browsing filters to fing challeng near you</li>
        <li>we also use rating systems to make it easy to play with someone whit similar level </li>
        <li> so register and CHALLENGE!!</li>
    </ul>
    <h3>Some text.</h3>
    <p style="text-align: justify; line-height: 20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse in velit lobortis, pharetra nunc a, eleifend nunc. Ut ac lacinia sem, a hendrerit risus. Proin dictum tristique sapien, at rhoncus sapien posuere at. Aliquam elementum vitae ante ut dictum.</p>
    <p>Phasellus tristique, mi eu fermentum sodales, lectus turpis rhoncus felis, nec vehicula nisl dolor id sapien. Suspendisse eget laoreet turpis. Pellentesque sit amet velit tristique, posuere mauris eget, tempor tortor. Pellentesque tempor, enim quis ornare facilisis, tortor enim hendrerit tellus, non laoreet leo eros sed dolor. Donec a ligula et sapien luctus rhoncus sit amet et purus.</p>
</div>
<div id="registerPanel" style="background: #eee; border: solid 1px #ddd; padding: 20px 30px; float: right; width: 300px;">
    <h3 style="margin: 0 0 10px;">Sign up</h2>
    <?php if ($error == 2): ?>
        <div class="alert">This username is taken.</div>
    <?php endif; ?>
    <form action="" method="post" style="margin-bottom: 10px;">
        <strong>Name</strong><br>
        <input type="text" name="name" id="name" placeholder="First" required> <input type="text" name="surname" id="surname" placeholder="Last" required><br>
        <strong>Username</strong><br>
        <input type="text" name="username" id="uname" placeholder="Username" required><br>
        <strong>Password</strong><br>
        <input type="password" name="password" id="passwd" placeholder="Password" required><br>
        <strong>Confirm password</strong><br>
        <input type="password" name="password2" id="passwd" placeholder="Same password" required><br>
        <strong>Email address</strong><br>
        <input type="text" name="email" id="email" placeholder="user@email.com" required><br>
        <strong>City</strong><br>
        <input type="text" name="city" id="city" placeholder="Paris" required><br>
        <strong>Country</strong><br>
        <input type="text" name="country" id="country" placeholder="France" required>
        <input type="submit" class="btn btn-primary" value="Sign up" name="signup" id="register">
    </form>
    <a href="./?user=login">Already a member?</a>
</div>