<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Session;
use think\Config;
use think\Request;

class Logsys extends AdminBase
{
	public function index()
	{
		return $this->fetch();
	}
}