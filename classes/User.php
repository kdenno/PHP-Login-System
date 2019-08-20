<?php
class User
{
    private $_db,
        $_data,
        $_sessionName,
        $_LoggedIn;
    public function __construct($user = null)
    {
        // get access to database
        $this->_db = DB::getInstance();
        // get user session
        $this->_sessionName = Config::get('session/session_name');

        if (!$user) {
            // check if user is logged in
            if (Session::exists($this->_sessionName)) {
                // get user id
                $user = Session::get($this->_sessionName);
                // get user data
                if ($this->find($user)) {
                    $this->_LoggedIn = true;
                } else {
                    // process logout
                }
            }
        } else {
            // if its a logged in user, get user data


        }
    }
    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function login($username = null, $password = null)
    {
        $user = $this->find($username);
        if ($user) {
            // check password by regenerating a hash and comparing it with the one in the DB
            if ($this->data()->$password === Hash::make($password, $this->data()->$salt)) {
                // passwords match, add user info to session i.e login user
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn()
    {
        return $this->_LoggedIn;
    }

    public function logout()
    {
        // delete session
        Session::delete($this->$_sessionName);
    }
}
