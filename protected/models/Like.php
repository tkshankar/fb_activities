<?php

class Like extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return static the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{likes}}';
	}
		
	public function findByLikeId($post_id,$user_id) 
	{
		$cr = new CDbCriteria();
		$cr->addCondition("post_id = :post_id");
		$cr->addCondition("user_id = :user_id");
		$cr->params = array(":user_id" => $user_id,":post_id" => $post_id);
		return $this->find($cr);
	}
	
	public function findAllLikes($page_id)
	{
		$cr = new CDbCriteria();
		$cr->addCondition("page_id = :page_id");
		$cr->params = array(":page_id" => $page_id);
		return $this->findAll($cr);
	}
	
}