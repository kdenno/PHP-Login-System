<?php
// get all classes
require_once 'core/init.php';
$validation = new Validation;
$validate = $validation->check($_POST, array(
    'username' => array(
        'required' => true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users'
    ),
    'password' => array(
        'required' => true,
        'min' => 6
    ),
    'password_again' => array(
        'required' => true,
        'matches' => 'password'
    ),
    'name' => array(
        'required' => true,
        'min' => 2,
        'max' => 50
    )
));
if ($validate->passed()) {
    echo 'passed';
} else {
    print_r($validation->errors());
}
?>
<form method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php escape(Input::get('username')) ?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" value="" id="password">
    </div>
    <div class="field">
        <label for="password_again">Password Again</label>
        <input type="password" name="password_again" value="" id="password_again">
    </div>
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php escape(Input::get('name')) ?>" id="name">
    </div>
    <div class="field">
        <input type="submit" value="Register">
    </div>

</form>