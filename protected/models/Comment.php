<?php

class Comment extends CActiveRecord
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
		return '{{comments}}';
	}
	
	public function findByCommentId($comment_id) 
	{
		$cr = new CDbCriteria();
		$cr->addCondition("comment_id = :comment_id");
		$cr->params = array(":comment_id" => $comment_id);
		return $this->find($cr);
	}
	
	public function findAllComments($page_id)
	{
		$cr = new CDbCriteria();
		$cr->addCondition("page_id = :page_id");
		$cr->params = array(":page_id" => $page_id);
		return $this->findAll($cr);
	}
	
}