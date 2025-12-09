<?php

$temperature = 9; 
$day = 1;


if (!is_numeric($temperature)) {
    echo "Invalid temperature value.<br>";
} else {

    if ($temperature < 10) {
        echo "It's cold.<br>";
    } elseif ($temperature >= 10 && $temperature <= 25) {
        echo "It's warm.<br>";
    } else {
        echo "It's hot.<br>";
    }
}


if (!is_numeric($day) || $day < 1 || $day > 7) {
    echo "Invalid day value.";
} else {
   
    switch ($day) {
        case 1:
            echo "Monday";
            break;
        case 2:
            echo "Tuesday";
            break;
        case 3:
            echo "Wednesday";
            break;
        case 4:
            echo "Thursday";
            break;
        case 5:
            echo "Friday";
            break;
        case 6:
            echo "Saturday";
            break;
        case 7:
            echo "Sunday";
            break;
    }
}
?>
