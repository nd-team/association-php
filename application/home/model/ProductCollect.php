<?php
namespace app\home\model;

use think\Model;
use think\Db;

class ProductCollect extends Model
{
	/**查询所有产品众筹内容
	*
    * $order  排序
	* $limit 条数 
	*
	**/
	public function all_content($order='id desc',$limit='*')
	{
		$product_collect=Db::table('ike_product_collect')
						->order($order)
						->limit($limit)
						->select();
		return $product_collect;
	}
}