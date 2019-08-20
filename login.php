<?php
require_once 'core/init.php';
// check whether form was submited
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
        if ($validation->passed()) {
            //log user in
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'));
            if ($login) {
                Redirect::to('index.php');
            } else {
                echo '<p>Sorry Login failed</p>';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>
<form>
    <div class="fields">
        <label for="username">
            Username
        </label>
        <input type="text" name="username" id="username">

    </div>
    <div class="fields">
        <label for="password">
            Password
        </label>
        <input type="password" name="password" id="password">
    </div>
    <div class="fields">
        <input type="hidden" name="token" value="<?php Token::generate(); ?>">
        <input type="submit" value="Log In">
    </div>

</form>