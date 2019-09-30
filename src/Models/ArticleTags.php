<?php
namespace JaguarJack\CatchAdmin\Models;

class ArticleTags extends BaseModel
{
 	protected $table = 'article_tags';

 	protected $fillable = [
		 'id',
		 'name', // 标签名称
		 'created_at', // 创建时间
		 'updated_at', // 更新时间
 	 ];
 }
