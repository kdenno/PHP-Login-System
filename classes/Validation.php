<?php
class Validation
{
    private $_passed = false,
        $_errors = array(),
        $_db = null;
    public function __construct()
    {
        // get database instance everytime this class is called
        $this->_db = DB::getInstance();
    }
    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            // loop through rules array
            foreach ($rules as $rule => $rule_value) {
                // get values submitted from the global arrays
                $value = trim($source[$item]);
                // check rule
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                // add error
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                // add error
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            // check if there is a count
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    private function addError($error)
    {
        // add error to errors array
        $this->_errors[] = $error;
    }

    // return errors
    public function errors()
    {
        return $this->_errors;
    }
    public function passed()
    {
        return $this->_passed;
    }
}
