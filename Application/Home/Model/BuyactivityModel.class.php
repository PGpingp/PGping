<?php
namespace Home\Model;

use Think\Model\RelationModel;

class BuyactivityModel extends RelationModel{
	protected $_link=array(
		'activity'=>array(
			'mapping_type'=>self::BELONGS_TO, 
 	    	'class_name'=>'Activity',
			'foreign_key'=>'activity_id',
			'mapping_name'=>'activitys',  
			//'mapping_order' => 'buyactivity_id desc', 
			'mapping_fields'=>'activity_theme,activity_poster', 
		),
	
	);	
}


