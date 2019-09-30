<?php
namespace JaguarJack\CatchAdmin\Observers\Db;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use JaguarJack\CatchAdmin\Models\ArticleCategory;

class ArticleObserver
{
    //
    /**
     * created
     *
     * @time 2019年09月17日
     * @param ArticleCategory $category
     * @return void
     */
    public function created(ArticleCategory $category)
    {
        if ($category->pid) {
            $parent = $category->where('id', $category->pid)->first();

            $category->level = $parent->level . '/' . $category->pid;

            $category->save();
        }
    }

    /**
     * delete
     *
     * @time 2019年09月17日
     * @param ArticleCategory $category
     * @return void
     */
    public function deleting(ArticleCategory $category)
    {
        if ($category->where('pid', $category->id)->first()) {
            throw new FailedException('该分类下存在子分类，请先删除');
        }
    }
}
