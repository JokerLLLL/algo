<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/7
 * Time: 14:23
 */

function simpleSort(&$array) {
    $count  = count($array);
    for($i = 0;$i < $count - 1;$i ++ ) {
        for($j = $i+1;$j < $count; $j ++) {
            if($array[$j] < $array[$i]) {
                list($array[$i],$array[$j]) = array($array[$j],$array[$i]);
            }
        }
    }
}




function bubblerSort(&$array) {
    $count = count($array);
    for($i = 0;$i < $count -1;$i ++ ) {
        for($j = $count - 1;$j - 1 >= $i; $j --) {
            if($array[$j -1] > $array[$j]) {
                list($array[$j-1],$array[$j]) = array($array[$j],$array[$j-1]);
            }
        }
    }
}

$rand = range(0,50);
shuffle($rand);
var_dump($rand);
simpleSort($rand);
var_dump($rand);

