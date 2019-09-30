<?php
namespace JaguarJack\CatchAdmin\Models;

use JaguarJack\CatchAdmin\Observers\Db\ArticleCategoryObserver;

class ArticleCategory extends BaseModel
{
 	protected $table = 'article_category';

 	protected $fillable = [
		 'id',
		 'pid', // 父级ID
		 'name', // 分类名称
		 'level', // 层级关系
		 'sub_amount', // 子级数量
		 'article_amount', // 文章数量
		 'created_at', // 创建时间
		 'updated_at', // 更新时间
 	 ];

 	protected static $observer = ArticleCategoryObserver::class;
 }
