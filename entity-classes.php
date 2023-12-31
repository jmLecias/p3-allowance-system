<?php
class Expense
{
    public $expenseID;
    public $allowanceID;
    public $amount;
    public $name;
    public $remarks;
    public $date;

    public function __construct($expenseID, $allowanceID, $amount, $name, $remarks, $date)
    {
        $this->expenseID = $expenseID;
        $this->allowanceID = $allowanceID;
        $this->amount = $amount;
        $this->name = $name;
        $this->remarks = $remarks;
        $this->date = $date;
    }
}

class Allowance
{
    public $allowanceID;
    public $userID;
    public $amount;
    public $name;
    public $description;
    public $date;
    public $category;

    public function __construct($allowanceID, $userID, $amount, $title, $description, $date, $category)
    {
        $this->allowanceID = $allowanceID;
        $this->userID = $userID;
        $this->amount = $amount;
        $this->name = $title;
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
    public $password;
    public $role;

    public function __construct($userID, $firstname, $lastname, $email,$password, $role)
    {
        $this->userID = $userID;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
}
?>