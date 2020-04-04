<?php

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
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $pass);
        $lowercase = preg_match('@[a-z]@', $pass);
        $number    = preg_match('@[0-9]@', $pass);

        if (empty($pass)) {
            $this->msg['password_err'] = 'Please enter password';
            return false;
        } elseif (strlen($pass) < 6) {
            $this->msg['password_err'] = 'Password must be at least 6 characters';
            return false;
        } elseif (!$uppercase || !$lowercase || !$number) {
            $this->msg['password_err'] = 'Password must include at least one uppercase, one lowercase and one number';
            return false;
        } else {
            return true;
        }
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