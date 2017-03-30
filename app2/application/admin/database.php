<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // ���ݿ�����
    'type'           => 'mysql',
    // ��������ַ
    'hostname'       => '127.0.0.1',
    // ���ݿ���
    'database'       => 'thinkphp',
    // �û���
    'username'       => 'root',
    // ����
    'password'       => 'root',
    // �˿�
    'hostport'       => '3306',
    // ����dsn
    'dsn'            => '',
    // ���ݿ����Ӳ���
    'params'         => [],
    // ���ݿ����Ĭ�ϲ���utf8
    'charset'        => 'utf8',
    // ���ݿ��ǰ׺
    'prefix'         => 'ike_',
    // ���ݿ����ģʽ
    'debug'          => true,
    // ���ݿⲿ��ʽ:0 ����ʽ(��һ������),1 �ֲ�ʽ(���ӷ�����)
    'deploy'         => 0,
    // ���ݿ��д�Ƿ���� ����ʽ��Ч
    'rw_separate'    => false,
    // ��д����� ������������
    'master_num'     => 1,
    // ָ���ӷ��������
    'slave_no'       => '',
    // �Ƿ��ϸ����ֶ��Ƿ����
    'fields_strict'  => true,
    // ���ݼ��������� array ���� collection Collection����
    'resultset_type' => 'array',
    // �Ƿ��Զ�д��ʱ����ֶ�
    'auto_timestamp' => false,
    // �Ƿ���Ҫ����SQL���ܷ���
    'sql_explain'    => false,
];
