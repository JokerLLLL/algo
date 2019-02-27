<?php


/** 最大堆 == 维护
 *  属性：索引 为0的数无效
 * parent(i) = floor(i/2);   i的父节点
 * left_child(i) = 2*i;      i的左子节点
 * left_child(i) = 2*i + 1;  i的右子节点
 *
 * Class Heap
 */
class Heap
{
    private $heap = ['this is heap'];

    public function __get($name)
    {
        if($name == 'size') {
            return count($this->heap)-1;
        }elseif($name == 'heap') {
            return $this->heap;
        }elseif(isset($this->heap[$name])) {
            return $this->heap[$name];
        }else{
            return Null;
        }
    }

    /** 堆中插入
     * @param $item
     */
    public function insert($item)
    {
         $this->heap[] = $item;
         $this->shiftUp($this->size);
    }


    public function pop()
    {
        if($this->size < 1) {
            return Null;
        }
        $temp_value = $this->heap[1];
        list($this->heap[$this->size],$this->heap[1]) = array($this->heap[1],$this->heap[$this->size]);
        unset($this->heap[$this->size]);
        $this->shiftDown(1);
        return $temp_value;
    }

    /** 将index 排序 完成最大堆
     * @param $index
     */
    private function shiftUp($index)
    {
        $new_index = floor($index/2);
        while($index >1 && $this->heap[$new_index] < $this->heap[$index]) {
            list($this->heap[$new_index] , $this->heap[$index])
                = array($this->heap[$index], $this->heap[$new_index]);
            $index = $new_index;
            $new_index = floor($new_index/2);
        }
    }

    /**将第index索引的位置维护成最大堆
     * @param $index
     */
    private function shiftDown($index)
    {
        //判断有左索引
        while(2*$index <= $this->size) {
            $change_index = 2*$index;
            if(($change_index +1 <= $this->size) && ($this->heap[$change_index + 1] > $this->heap[$change_index])) {
                $change_index += 1;
            }
            if($this->heap[$index] >= $this->heap[$change_index]) {
                break;
            }
            //跟换位置 继续循环
            list($this->heap[$change_index] , $this->heap[$index])
                = array($this->heap[$index], $this->heap[$change_index]);

            $index = $change_index;
        }
    }
}
$h = new Heap();
for ($i=1;$i<100;$i++)
{
    $h->insert(rand(1,100));
}

while (($value = $h->pop()) != null) {
    var_dump($value);
}
var_dump($h->heap);