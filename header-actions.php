<?php
function goToFirstPage($sessionRole)
{
    if ($sessionRole == "admin") {
        echo "window.location='user-list.php'";
    } else {
        echo "window.location='user-allowances.php'";
    }
}

function isAdmin($role) {
    echo ($role == "admin")? "hide": "";
}

?>