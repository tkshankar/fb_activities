<?php

class Feed extends CActiveRecord
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
		return '{{post}}';
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('post/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}
	
	public function findByPostId($post_id) 
	{
		$cr = new CDbCriteria();
		$cr->addCondition("post_id = :post_id");
		$cr->params = array(":post_id" => $post_id);
		return $this->find($cr);
	}
	
	public function findAllPost($page_id)
	{
		$cr = new CDbCriteria();
		$cr->addCondition("page_id = :page_id");
		$cr->params = array(":page_id" => $page_id);
		return $this->findAll($cr);
	}
	
}