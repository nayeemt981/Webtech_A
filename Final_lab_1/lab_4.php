<?php


function sum($a, $b) {
    return $a + $b;
}


function factorial($n) {
    if ($n <= 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}


function is_prime($n) {
    if ($n < 2) {
        return false;
    }
    for ($i = 2; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}





echo "1. Testing sum() function:\n";
echo "10 + 25 = " . sum(10, 25) . "\n";
echo "7 + 8 = " . sum(7, 8) . "\n";
echo "-5 + 12 = " . sum(-5, 12) . "\n\n";


echo "2. Testing factorial() function:\n";
echo "factorial(5) = " . factorial(5) . "\n";  
echo "factorial(0) = " . factorial(0) . "\n";  
echo "factorial(1) = " . factorial(1) . "\n";  
echo "factorial(6) = " . factorial(6) . "\n\n";  


echo "3. Testing is_prime() function:\n";
$numbers = [1, 2, 3, 4, 5, 7, 11, 13, 17, 20, 29, 31, 100];

foreach ($numbers as $num) {
    if (is_prime($num)) {
        echo "$num is a prime number.\n";
    } else {
        echo "$num is not a prime number.\n";
    }
}

?>