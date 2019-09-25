<?php
namespace JaguarJack\CatchAdmin\Service\Common;

class TreeService
{
    /**
     *
     * @var array
     */
    protected $items;

    /**
     * tree 结构
     *
     * @time 2019年09月17日
     * @param int $pid
     * @param string $pidField
     * @param string $childField
     * @return array
     */
    public function tree(int $pid = 0, string  $pidField = 'pid', string  $childField = 'children')
    {
        $tree = [];

        foreach ($this->items as $item) {
            if ($item[$pidField] == $pid) {
                $item[$childField] = $this->tree($item['id']);
                $tree[] = $item;
            }
        }

        return $tree;
    }


    /**
     * set data
     *
     * @time 2019年09月17日
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = is_object($items) ? $items->toArray() : $items;

        return $this;
    }
}
