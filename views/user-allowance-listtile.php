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

function displayAllowance($allowance, $expensesCount, $selected)
{
    $html = "
        <div class=\"row-div listtile-div\">
            <div class=\"row-div\" 
            style=\"width: 50%; justify-content: start\">
                <h1 class=\"secondary-text\"
                style=\"font-size: 16px; margin-left: 20px\">$allowance->title</h1>
                <div class=\"expenses-count-div\">$expensesCount items</div>
            </div>
            <div class=\"row-div\"
            style=\"width: 30%\; justify-content: end\">
                <h1 class=\"secondary-text\"
                style=\"font-size: 15px;  margin-right: 20px\">PHP $allowance->amount</h1>
                <h1 class=\"secondary-text\"
                style=\"font-size: 12px;  margin-right: 20px\">$allowance->category</h1>
            </div>
        </div>
    ";

    return $html;
}

?>