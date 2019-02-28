<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'',
	'DB_PWD'=>'',
	'DB_NAME'=>'',
	'DB_PORT'=>3306,
	'DB_PREFIX'=>'t_',
	'URL_HTML_SUFFIX'=>'html|shtml|xml',
	'TMPL_PARSE_STRING'=>array(           //添加自己的模板变量规则
		'__PUBLIC__'=>__ROOT__.'/Public/',
		'__CSS__'=>__ROOT__.'/Public/Css',
		'__JS__'=>__ROOT__.'/Public/Js',
		'__HEADIMG__'=>__ROOT__.'/Public/Users/headImg',
		),
	'TMPL_CACHE_ON'=>false,//模板缓存关闭
	'TMPL_CONTENT_TYPE'=>'text/html',
	'TMPL_ACTION_ERROR'=>THINK_PATH.'Tpl/dispatch_jump.tpl',
	'TMPL_ACTION_SUCCESS'=>THINK_PATH.'Tpl/dispatch_jump.tpl',
	'TMPL_EXCEPTION_FILE'=>THINK_PATH.'TPl/think_exception.tpl',	
	//默认参数过滤，I函数
	'DEFAULT_FILTER'=>'htmlspecialchars',
	//标签库预加载
	'TAGLIB_PRE_LOAD'=>'html',
	'URL_CASE_INSENSITIVE' =>true,
		
	 'THINK_EMAIL' => array(
       'SMTP_HOST'   => '114.215.157.158', //SMTP服务器
       'SMTP_PORT'   => '25', //SMTP服务器端口
       'SMTP_USER'   => '', //SMTP服务器用户名
       'SMTP_PASS'   => '', //SMTP服务器密码
       'FROM_EMAIL'  => '', //发件人EMAIL
       'FROM_NAME'   => '', //发件人名称
       'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
       'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
    ),
    
 
);
