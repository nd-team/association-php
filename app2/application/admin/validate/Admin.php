<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{

    protected $rule =   [
        'admin_name'              => 'require|max:11',
        'password'                => 'length:6,20',
    ];

    protected $message  =   [
        'admin_name.require'      => '账号不能为空',
		'admin_name.max'			=>'账号不能超过11个字符',
        'password.length'       => '密码应在6-20之间',
    ];

    protected $scene = [
        'admin'                 =>  ['admin_name','password'],
    ];

}


