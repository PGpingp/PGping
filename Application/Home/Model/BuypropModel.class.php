<?php
namespace Home\Model;

use Think\Model\RelationModel;

class BuypropModel extends RelationModel{
	protected $_link=array(
		'prop'=>array(
			'mapping_type'=>self::BELONGS_TO, 
 	    	'class_name'=>'Prop',
			'foreign_key'=>'prop_id',
			'mapping_name'=>'props',  
			//'mapping_order' => 'buyactivity_id desc', 
			'mapping_fields'=>'prop_name,prop_poster', 
		),
	
	);	
}


