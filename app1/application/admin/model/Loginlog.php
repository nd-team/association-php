<?php
namespace app\admin\model;

use \think\Config;
use \think\Model;
use \think\Session;

class Loginlog extends Model
{
	public function record($remark,$address,$ip)
    {
        $this->save(['log_content' => $remark,'log_ip'=>$ip,'log_address'=>$address,'log_login_time'=>date("Y-m-d H:i:s")]);
    }
}