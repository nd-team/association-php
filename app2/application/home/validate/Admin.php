<?php
namespace app\home\validate;

use think\Validate;

class Admin extends Validate
{

    protected $rule =   [
        'tu_id'              => 'require|max:11',
        'password'                => 'length:6,20',
    ];

    protected $message  =   [
        'tu_id.require'      => '账号不能为空',
		'tu_id.max'			=>'账号不能超过11个字符',
        'password.length'       => '密码应在6-20之间',
    ];

    protected $scene = [
        'admin'                 =>  ['tu_id','password'],
    ];

}


