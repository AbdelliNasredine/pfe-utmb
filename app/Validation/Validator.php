<?php

namespace App\Validation;

use App\Models\User;

class Validator
{
    /*
     *
     *
     *  class de validation de données
     *
     *
     */

    private $regex_string = '/^[a-zA-Z ]+$/';

    protected $flash;

    public $errors = false;

    public function __construct($flash)
    {
        $this->flash = $flash;
    }

    public  function validateAll($request, array $values)
    {

        foreach ($values as $value) {
            if (empty($request->getParam($value))) {
                $this->flash->addMessage('errors', "Champ " . ucfirst($value) . " ne doit pas étre vide ");
                $this->errors = true;
            }
        }
        return $this;
    }

    public function isString($value)
    {
        return preg_match($this->regex_string , $value) ? true : false;
    }

    public function isPassword($pass ,$passConf)
    {
        return $pass === $passConf;
    }

    public function isEmail($email)
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $user  = User::where('email', $email)->first();
        if($user){
            return false;
        }
        return true;
    }

    public function valid()
    {
        return $this->errors == false;
    }

}
