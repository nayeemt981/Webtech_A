<?php

$name = "Nayeem";      
$age = 24;           
$height = 5.6;       
$isStudent = true;   


echo "<h3>Variable Types & Values:</h3>";
var_dump($name);
echo "<br>";
var_dump($age);
echo "<br>";
var_dump($height);
echo "<br>";
var_dump($isStudent);
echo "<br><br>";


$num1 = 15;
$num2 = 4;

$addition = $num1 + $num2;
$subtraction = $num1 - $num2;
$multiplication = $num1 * $num2;
$division = $num1 / $num2;

echo "<h3>Arithmetic Results:</h3>";
echo "Addition: $addition <br>";
echo "Subtraction: $subtraction <br>";
echo "Multiplication: $multiplication <br>";
echo "Division: $division <br><br>";


$sum = $num1 + $num2;

echo "<h3>Output Using echo & print:</h3>";
echo "Using echo: The sum is $sum <br>";
print "Using print: The sum is $sum <br>";
?>
