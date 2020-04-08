<?php
require_once APPROOT . '/libraries/CheckPassword.php';

class Validate {

    protected $msg = [];

    public function validateFirstName($name)
    {
        if (empty($name)) {
            $this->msg['first_name_err'] = 'First name is empty';
            return false;   
        } else {
            return true;
        }
    }

    public function validateLastName($name)
    {
        if (empty($name)) {
            $this->msg['last_name_err'] = 'Last name is empty';
            return false;   
        } else {
            return true;
        }
    }

    public function validateEmail($email)
    {
        if (empty($email)) {
            $this->msg['email_err'] = 'Please enter email address';
            return false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->msg['email_err'] = 'Invalid email format';
            return false;
        } else {
            return true;
        }
    }

    public function validatePass($pass)
    {
        $check = new CheckPassword($pass, 6);
        $check->requireNumbers();
        $check->requireMixedCase();
        $result = $check->check();
        $this->msg['password_err'] = $check->getErrors();

        return $result;
    }

    public function validateConfPass($pass, $confPass)
    {
        if (empty($confPass)) {
            $this->msg['confirm_password_err'] = 'Please enter confirm password';
            return false;
        } else {
            if ($pass !== $confPass) {
                $this->msg['confirm_password_err'] = 'Confirm password isn\' match';
                return false;
            } else {
                return true;
            }
        }
    }

    public function getMsg()
    {
        return $this->msg;
    }

}