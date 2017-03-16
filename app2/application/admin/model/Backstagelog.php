<?php
namespace app\admin\model;

use \think\Config;
use \think\Model;
use \think\Session;

class Backstagelog extends Model
{
	public function record($remark)
    {
        $this->save(['content' => $remark,'gen_time'=>date("Y-m-d H:i:s")]);
    }
}