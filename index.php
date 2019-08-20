<?php
// import configs
require_once 'core/init.php';
if (Session::exists('home')) {
    echo '<p>' . Session::flash('success') . '</p>';
}

$user = new User();
if ($user->isLoggedIn()) { ?>
<p>Hello <a href=""><?php echo $user->data()->username; ?></a>!</p>
<ul>
    <li><a href="logout.php">Logout</a></li>

</ul>

<?php
} else {
    echo 'You need to <a href="login.php">Login</a> or <a href="register.php">Register</a>';
}
