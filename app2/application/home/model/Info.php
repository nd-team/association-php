<?php
namespace app\home\model;

use think\Model;
use think\Db;

class Info extends Model
{
	public function index()
	{
		$product_collect=Db::table('ike_product_collect')
						->order('id desc')
						->limit('*')
						->select();
		return $product_collect;
	}
}