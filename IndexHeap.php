<?php

/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2019/3/2
 * Time: 14:16
 */


/**
 *  Class IndexHeap 堆的实现 从索引 0 开始
 *  parent(i) = floor((i+1)/2) - 1
 *  left_child(i) = 2(i+1) -1;
 *  right_child(i) = 2(i+1);
 */

class IndexHeap
{
     private $list = [];
     private $index = []; //index 的索引值 符合一个堆 内容对于 list的索引
    /**
     *  reverse[index[i]] == i;
     *  index[reverse[i]] == i;
     */
     private $reverse = []; // 就是index 键和值的互换

     private static function getParentIndex($i)
     {
         return intval(floor(($i+1)/2) - 1);
     }
     private static function getLeftIndex($i)
     {
         return 2*($i+1) -1;
     }
     private static function getRightIndex($i)
     {
         return 2*($i+1);
     }

    /** 判断 $a 大于 $b
     * @param $a
     * @param $b
     * @return bool
     */
     private static function operation(&$a, &$b)
     {
         return boolval(($a < $b));
     }

     private function keepReverse($index)
     {
         $this->reverse[$this->index[$index]] = $index;
     }

     public function isEmpty()
     {
         return empty($this->index);
     }

     public function insert($item)
     {
         $this->list[] = $item;
         $this->index[] = count($this->list) - 1; //把 list的 索引写到 index里
         //添加反向索引
         $this->reverse[count($this->list) - 1] = count($this->index) - 1;
         $this->shiftUp(count($this->index) - 1); //index 里 最后 一个元素是刚插入的
     }

    public function pop()
    {

        if($this->isEmpty())
            return null;

        $temp_value = $this->list[$this->index[0]];
        //先删除反向索引
        unset($this->reverse[$this->index[0]]);
        //unset($this->list[$this->index[0]]); 列表的数组可以不删除 ；；； 索引在堆里已经不存在了
        $this->index[0] = $this->index[count($this->index)-1];
        //删除索引
        unset($this->index[count($this->index)-1]);
        $this->shiftDown(0);

        return $temp_value;
    }

    public function popIndex()
    {

        if($this->isEmpty())
            return null;

        $temp_value =$this->index[0];
        //先删除反向索引
        unset($this->reverse[$this->index[0]]);

        //unset($this->list[$this->index[0]]); 列表的数组可以不删除 ；；； 索引在堆里已经不存在了
        $this->index[0] = $this->index[count($this->index)-1];

        //删除索引
        unset($this->index[count($this->index)-1]);

        $this->shiftDown(0);

        return $temp_value;
    }

    public function changeItem($list_index,$item)
    {
/*         $get_index = array_search($list_index,$this->index);
         if($get_index === false) {
             throw new Exception('不存在该索引');
         }*/
         if(!isset($this->reverse[$list_index]))
             throw new Exception('不存在该索引');
         $get_index = $this->reverse[$list_index];
         $this->list[$list_index] = $item;
         $this->shiftUp($get_index);
         $this->shiftDown($get_index);
    }

    /** 将index索引的自底向上放到合适的位置
     * @param $index
     */
     public function shiftUp($index)
     {
         $p_index = self::getParentIndex($index);
         while($index > 0 && !self::operation(
             $this->list[$this->index[$p_index]],
             $this->list[$this->index[$index]])
         ) {
             //交换索引
             list($this->index[$p_index] , $this->index[$index])
                 = array($this->index[$index], $this->index[$p_index]);
             //反向索引维护
             $this->keepReverse($p_index);
             $this->keepReverse($index);

             $index = $p_index;
             $p_index = self::getParentIndex($index);
         }
     }


    public function shiftDown($index)
    {
        //判断有左索引
        while(self::getLeftIndex($index) <= count($this->index) - 1) {
            $change_index = self::getLeftIndex($index);
            //是否有有所右索引 且右索引符合条件
            if(($change_index + 1 <= count($this->index) - 1) &&
                self::operation(
                    $this->list[$this->index[$change_index + 1]],
                    $this->list[$this->index[$change_index]]
                )
            ) {
                $change_index += 1;
            }

            if(self::operation($this->list[$this->index[$index]], $this->list[$this->index[$change_index]]
            )) {
                break;
            }
            //跟换位置 继续循环
            list($this->index[$change_index] , $this->index[$index])
                = array($this->index[$index], $this->index[$change_index]);
            //反向索引
            $this->keepReverse($change_index);
            $this->keepReverse($index);

            $index = $change_index;
        }
    }

    public function die()
    {
        var_dump($this->index,$this->reverse);die;
    }

}

$arr = range(1000,1100,10);
shuffle($arr);
$index_heap = new IndexHeap();
foreach ($arr as $value) {
    $index_heap->insert($value);
    $index_heap->insert($value);
}
$index_heap->changeItem(5,666);
$index_heap->changeItem(7,999);

$t = [];
while (!$index_heap->isEmpty()) {
    $t[] = $index_heap->pop();
}
var_dump($t);


