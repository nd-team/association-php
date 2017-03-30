<?php
namespace app\common\exception;
use think\exception\Handle;
use think\exception\HttpException;
class Http extends Handle
{

    public function render(\Exception $e)
    {
		
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        }
        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        $array=parent::render($e);
		$a='';
		require './public/404/index.html';exit;
    }

}