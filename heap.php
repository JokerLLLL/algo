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
        list($this->heap[$this->size],$this->heap[1]) = array($this->heap[1],$this->heap[$this->size]);

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

}
$h = new Heap();
for ($i=1;$i<10;$i++)
{
    $h->insert(rand(1,10));
}

var_dump($h->heap);