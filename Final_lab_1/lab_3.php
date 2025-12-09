<?php


echo "Numbers from 1 to 20 (for loop):\n";
for ($i = 1; $i <= 20; $i++) {
    echo $i . " ";
}
echo "\n\n";


echo "Even numbers from 1 to 20 (while loop):\n";
$num = 2;
while ($num <= 20) {
    echo $num . " ";
    $num += 2;
}
echo "\n\n";


$fruits = [
    "apple"      => "red",
    "banana"     => "yellow",
    "orange"     => "orange",
    "grape"      => "purple",
    "lemon"      => "yellow",
    "watermelon" => "green",
    "strawberry" => "red",
    "mango"      => "yellow"
];


echo "All fruits and their colors (foreach loop):\n";
foreach ($fruits as $fruit => $color) {
    echo "The $fruit is $color.\n";
}
echo "\n";


echo "First 5 fruits only (foreach with break):\n";
$count = 0;
foreach ($fruits as $fruit => $color) {
    echo "The $fruit is $color.\n";
    $count++;
    if ($count == 5) {
        break;  
    }
}

?>