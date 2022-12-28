<?php

$arr = array(1, 2, 3, 32, 5, 6, 12);

$a = 1;

$num = count($arr);

for ($i = 0; $i < $num; $i++){

    if (strrpos($arr[$i], "2") !== false) {
        $num++;

        for ($j = $num - 1; $j > $i; $j--){
            $arr[$j] = $arr[$j-1];
        }

        $i++;
        $arr[$i] = $a;   
    }   
}

foreach ($arr as $x) 
{
    echo "$x ";
}

?>