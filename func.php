<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/7
 * Time: 14:23
 */

//简单排序
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



//冒泡排序
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

//插入排序
function inserSort(&$array) {
    $count = count($array);
    for($i = 1;$i < $count;$i ++) {
        $temp = $array[$i];
       for($j=$i;$j > 0 && $array[$j-1] > $temp;$j--) {
           $array[$j] = $array[$j-1];
       }
       $array[$j] = $temp;
    }
}

//希尔排序
function shellSort(&$array) {
    $incr = $count = count($array);
    do{
        $incr = floor($incr/3) + 1; //第一次的增量必须是分成 两两比较的结果
        for ($i = $incr;$i < $count;$i++) {
//            $temp = $array[$i];
            for($j = $i; $j >= $incr && ($array[$j] < $array[$j - $incr]);$j -= $incr) {
//                $array[$j] = $array[$j-$incr];
                list($array[$j],$array[$j - $incr]) = array($array[$j-$incr],$array[$j]);
            }
//            $array[$j] = $temp;
        }
    }while($incr > 1);
}

//归并排序
function mergeSort(&$array,$left,$right)
{
    if($left >= $right)
        return;
    $mid = floor(($left+$right)/2);
    $fuc = __FUNCTION__;
    $fuc($array,$left,$mid);
    $fuc($array,$mid+1,$right);
    doMerge($array,$left,$mid,$right); //进行归并
}
function doMerge(&$array,$left,$mid,$right) {
    //优化 如果 mid < mi + 1 说明本来就有序的
    if($array[$mid] <= $array[$mid+1])
        return;
    $temp_array = array_slice($array,$left,intval($right - $left + 1));
    //辅助数组的帮助索引位置 $i 要处理的左边 $j 要处理的右边
    $i = $left;  $j = $mid + 1;
    //原始数组 $k 等待要放入的位置
    for($k = $left;$k <= $right; $k++) {
        //处理越界问题
        if($i > $mid) {
            $array[$k] = $temp_array[$j - $left];
            $j ++;
        }elseif ($j > $right) {
            $array[$k] = $temp_array[$i - $left];
            $i ++;
        }elseif ($temp_array[$i - $left] > $temp_array[$j - $left]) {
            $array[$k] = $temp_array[$j - $left];
            $j ++;
        }else{
            $array[$k] = $temp_array[$i - $left];
            $i ++;
        }
    }

}

//向上归并
function mergeSortUp(&$array){
    $count = count($array);
    for($sz = 1;$sz < $count - 1;$sz += $sz) { //步长设置
        for($i = 0;$i + $sz < $count;$i += 2*$sz) {
            $mid = $i + $sz -1; //中间值 < $count -1
            $right = min($count - 1,$i + 2*$sz -1); //最右值
            doMerge($array,$i,$mid,$right);
        }
    }
}

function test(&$array) {
    $count = count($array);
    for($sz = 1;$sz < $count;$sz += $sz) {
        for($i = 0;$i + $sz < $count;$i += 2*$sz) {
            $mid = $i + $sz -1; // < count -1
            $right = min($i + 2*$sz -1,$count -1); // 和 count -1 取最小
            doMerge($array,$i,$mid,$right);
        }
    }
}

//快速排序
function quickSort(&$array,$l,$r) {
    if($l >= $r) {
        return;
    }
    $temp_value = $array[$l]; //比对值
    $j = $l;     // [$l+1,$j] < $temp_value
    $k = $r + 1; // [$k,$r] > $temp_value
    $i = $l + 1; // [$j+1,$i-1] == $temp_value  定义 $i是将要被审查的元素
    while($i < $k) {
        if($array[$i] < $temp_value) {
            //当含有相同 temp_value 时候 进行 互换位置
            if($i > $j + 1) {
                list($array[$j+1],$array[$i]) = array($array[$i],$array[$j+1]);
            }
            $j++;
            $i++;
        }elseif ($array[$i] == $temp_value) {
            $i ++;
        }else{
            list($array[$k-1],$array[$i]) = array($array[$i],$array[$k-1]);
            $k--;
        }
    }
    //第一个 和  < temp_value 的最后一个互换位置 使用 [l,$j-1] < temp_value
    list($array[$l],$array[$j]) = array($array[$j],$array[$l]);

    //递归进行排序
    $func = __FUNCTION__;
    $func($array,$l,$j-1);
    $func($array,$k,$r);
}

$rand = range(0,50);
shuffle($rand);
var_dump($rand);
quickSort($rand,0,50);
var_dump($rand);

