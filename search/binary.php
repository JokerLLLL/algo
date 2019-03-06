<?php

/*
 * 二分查找法  【只能使用在有序的数组】
 * 如果没有 target 返回 null 否则返回索引
 */
function binary($target,$array) {
    $l = 0;
    $r = count($array) - 1;
    while ($l <= $r) {
        $mid = floor($l + ($r - $l)/2);
        if($array[$mid] == $target)
            return $mid;
        if($array[$mid] > $target) {
            $r = $mid - 1;
        }else{
            $l = $mid + 1;
        }
    }
    return null;
}

$array = [1,2,46,77,88,99,101,120,130,140,150];

var_dump(binary(88,$array));
