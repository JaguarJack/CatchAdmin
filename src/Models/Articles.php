<?php
namespace JaguarJack\CatchAdmin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends BaseModel
{
    use SoftDeletes;

 	protected $table = 'articles';

 	protected $fillable = [
		 'id',
		 'category_id', // 分类ID
		 'title', // 文章标题
		 'content', // 文章内容
		 'author', // 作者
		 'thumb_img', // 缩略图
		 'pv', // 默认的PV数量
		 'tags', // 标签
		 'created_at', // 创建时间
		 'updated_at', // 更新时间
		 'deleted_at'
 	 ];
 }
