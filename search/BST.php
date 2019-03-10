<?php

class Node{
      public $key;
      public $value;
      public $left;
      public $right;
      public function __construct($key,$value)
      {
          $this->key = $key;
          $this->value = $value;
          $this->left = $this->right = null;
      }
}

class BST
{
    /**
     * @var $root Node
     */
    public $root;
    public $count;

    public function __construct()
    {
        $this->root = null;
        $this->count = 0;
    }

    public function size()
    {
        return $this->count;
    }

    public function isEmpty()
    {
        return $this->count == 0;
    }

    /** 插入
     * @param $key
     * @param $value
     */
    public function insert($key, $value)
    {
        $this->__insert($this->root, $key, $value);
    }

    /**
     * @param $node Node
     * @param $key
     * @param $value
     */
    private function __insert(&$node, $key, $value)
    {
        if ($node == null) {
            $this->count++;
            $node = new Node($key, $value);
        }

        $diff = self::operation($key, $node->key);

        if ($diff === 0)
            $node->value = $value;
        elseif ($diff < 0)
            $this->__insert($node->left, $key, $value);
        else
            $this->__insert($node->right, $key, $value);
    }

    /** before 比 after 小就返回 -1
     * @param $before_key
     * @param $after_key
     * @return int
     */
    private static function operation($before_key, $after_key)
    {
        $cmp = strcmp($before_key, $after_key);
        if ($cmp == 0)
            return 0;
        elseif ($cmp < 0)
            return -1;
        else
            return 1;
    }

    /** 以node为根 是否含有key的节点
     * @param $key
     */
    public function contain($key)
    {
        $this->__contain($this->root, $key);
    }

    /**
     * @param $node Node
     * @param $key
     * @return bool
     */
    private function __contain($node, $key)
    {
        if ($node === null)
            return false;

        if ($node->key == $key)
            return true;

        if (self::operation($key, $node->key) < 0)
            $this->__contain($node->left, $key);
        else
            $this->__contain($node->right, $key);
    }


    /**
     * @param $key
     * @return null
     */
    public function search($key)
    {
        return $this->__search($this->root, $key);
    }

    /**
     * @param $node Node
     * @param $key
     * @return null
     */
    private function __search($node, $key)
    {
        if ($node == null) {
            return null;
        }
        if ($node->key == $key) {
            return $node->value;
        }
        if (self::operation($key, $node->key) < 0)
            return $this->__search($node->left, $key);
        else
            return $this->__search($node->right, $key);
    }




    /**
     * 前序遍历
     */
    public function readFront()
    {
        $result = [];
        $this->__readFront($this->root, $result);
        return $result;
    }

    /**
     * @param $node Node
     * @param $result
     */
    private function __readFront($node, &$result)
    {
        //前
        $result[] = $node->key;
        if ($node->left !== null) {
            $this->__readFront($node->left, $result);
        }
        if ($node->right !== null) {
            $this->__readFront($node->right, $result);
        }

    }


    /**
     * 中序遍历
     */
    public function readMid()
    {
        $result = [];
        $this->__readMid($this->root, $result);
        return $result;
    }

    /**
     * @param $node Node
     * @param $result
     */
    private function __readMid($node, &$result)
    {
        if ($node->left !== null) {
            $this->__readMid($node->left, $result);
        }
        $result[] = $node->key;
        if ($node->right !== null) {
            $this->__readMid($node->right, $result);
        }
    }


    /**
     * 后序遍历
     */
    public function readEnd()
    {
        $result = [];
        $this->__readEnd($this->root, $result);
        return $result;
    }

    /**
     * @param $node Node
     * @param $result
     */
    private function __readEnd($node, &$result)
    {
        if ($node->left !== null) {
            $this->__readEnd($node->left, $result);
        }
        if ($node->right !== null) {
            $this->__readEnd($node->right, $result);
        }
        $result[] = $node->key;
    }


    /** 层序遍历一遍
     * @return array
     */
    public function readFloor()
    {
        $list = [$this->root];
        $result = [];
        while (!empty($list)) {
            /**
             *  错误使用了 array_pop  进行队列但弹出 发现了 前序便利的逆序方法
             */

            $this->__readFloor(array_shift($list), $list, $result);
        }
        return $result;
    }

    private function __readFloor($node, &$list, &$result)
    {
        if ($node === null) {
            return;
        }
        //左边入队
        if ($node->left) {
            array_push($list, $node->left);
        }
        //右边入队
        if ($node->right) {
            array_push($list, $node->right);
        }
        $result[] = $node->key;
    }


    public function delMin()
    {
        $this->__delMin($this->root);
    }

    /**
     * @param $node Node
     * @return null
     */
    private function __delMin(&$node)
    {
        if($node == null) {
            return null;
        }
        if($node->left === null) {
            if($node->right === null) {
                //删除这个节点 不能用 unset
                $node = null;
            }else{
                $node = $node->right;
            }
            $this->count --;
        }else{
            $this->__delMin($node->left);
        }
    }

    public function delMax()
    {
        $this->__delMax($this->root);
    }

    /** 删除最右点
     * @param $node Node
     * @return null
     */
    private function __delMax(&$node)
    {
        if($node === null){
            return null;
        }
        if($node->right === null) {
            if($node->left === null) {
                $node = null;
            }else{
                $node = $node->left;
            }
            $this->count --;
        }else{
            $this->__delMax($node->right);
        }

    }

    public function delByKey($key)
    {
        $this->__delByKey($this->root,$key);
    }

    private function __delByKey(&$node,$key)
    {
         if($node === null) {
             return null;
         }
         if(self::operation($key,$node->key) < 0) {
             $this->__delByKey($node->left,$key);
         }elseif (self::operation($key,$node->key) > 0) {
             $this->__delByKey($node->right,$key);
         }else{
             //进行删除
             if($node->left === null) {
                 $node = $node->right;
                 $this->count --;
             }elseif ($node->right === null) {
                 $node = $node->left;
                 $this->count --;
             }else{
                 //左右都有孩子 删除 right 的 最小值并把最小值 赋给当前位置
                 /**
                  * @var $minNode Node
                  */
                $minNode = $this->__getMinNode($node->right); //获取右边最小值并代替当前位置
                $this->__delMin($node->right);
                $minNode->left = $node->left;
                $minNode->right = $node->right;
                $node = $minNode;
                $this->count --;
             }
         }

    }

    /** 获取最小值的引用
     * @param $node
     * @return null
     */
    private function __getMinNode(&$node)
    {
        if($node == null) {
            return null;
        }
        if($node->left === null) {
            return $node;
        }else{
            return $this->__getMinNode($node->left);
        }
    }

}


$tree = new BST();

$a = ['a','c','b',5,5,5,55,55,67,22,5,5,7,4,'ttttt',7,5,7,54,5,878,'cccc','cccc','xxxxxxxxxxxxx'];


foreach ($a as $k => $v){
    $node_value = $tree->search($v);

    if($node_value === null) {
        $tree->insert($v,1);
    }else{
        $tree->insert($v,$node_value+1);
    }
}
//var_dump($tree->root);
//var_dump($tree->search('cccc'));
//var_dump($tree->readFront());
//var_dump($tree->readMid());
//var_dump($tree->readEnd());
//var_dump($tree->readFloor());

//$tree->delMin();

$tree ->delByKey('c');
$tree ->delByKey('cccc');
var_dump($tree->root);
