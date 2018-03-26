<?php
/**
 * Created by PhpStorm.
 * User: h3e
 * Date: 26.03.2018
 * Time: 20:16
 */

class Person
{
    private $id;
    private $name;
    private $email;
    private $phonenumber;

    function __construct($id = null, $name = null, $email = null, $phonenumber=null)
    {
        //ToDo trimm strings email vailededtor
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
    }

    /*vailedFunctions*/
    private function vailedName()
    {
        $boolean = TRUE;
        if($this->name === "" or (strlen($this->name) < 3))
        {
            $boolean = FALSE;
        }
        return $boolean;
    }

    private function vailedEmail()
    {
        $boolean = TRUE;
        if($this->email === "")
        {
            $boolean = FALSE;
        }
        return $boolean;
    }

    private function vailedPhonenumber()
    {
        $boolean = TRUE;
        if($this->email !== "" and !preg_match("[\d \+\/\-\)\(]{10, 15}", $this->email))
        {
            $boolean = FALSE;
        }
        return $boolean;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
}