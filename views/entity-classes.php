<?php
class Allowance
{
    public $allowanceID;
    public $userID;
    public $amount;
    public $title;
    public $description;
    public $date;
    public $category;

    public function __construct($allowanceID, $userID, $amount, $title, $description, $date, $category)
    {
        $this->allowanceID = $allowanceID;
        $this->userID = $userID;
        $this->amount = $amount;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->category = $category;
    }
}

class User
{
    public $userID;
    public $firstname;
    public $lastname;
    public $email;
    public $role;

    public function __construct($userID, $firstname, $lastname, $email, $role)
    {
        $this->userID = $userID;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->role = $role;
    }
}
?>