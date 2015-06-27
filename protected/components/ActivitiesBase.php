<?php
Yii::import('application.library.facebook-sdk.*');
require_once 'autoload.php';
use Facebook\FacebookResponse;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\GraphObject;

class ActivitiesBase extends Controller
{	
	public $facebookappid;
	public $facebookscret;
	
	const POST_QUERY = 'application,caption,coordinates,call_to_action,created_time,description,expanded_height,expanded_width,feed_targeting,from,full_picture,height,id,is_hidden,is_published,link,message,message_tags,name,object_id,parent_id,picture,place,privacy,promotion_status,properties,scheduled_publish_time,shares,source,status_type,story,story_tags,subscribed,targeting,timeline_visibility,to,type,updated_time,via,width,with_tags,comments.summary(true),likes.summary(true)';


	public function init()
	{
		$this->facebookappid = Yii::app()->params['facebook']['appId'];
		$this->facebookscret = Yii::app()->params['facebook']['secret'];
	}		
	
	/**
	 * Get the Page info for the selected by using Page ID or Name.
	 */
	public function getPage($page_id) 
	{	
		try {
			$access_token=$this->facebookappid."|".$this->facebookscret;			
			FacebookSession::setDefaultApplication($this->facebookappid, $this->facebookscret);
			$session = new FacebookSession($access_token);
			$page_query="/".$page_id;
			$page_result=$this->FBrequest($session,$page_query);
			return $page_result;						
			} catch (Exception $e) {
			//echo $e->getMessage();
			}			
	}
	
	/**
	 * Get the Post details for the selected by using Page ID.
	 */
	public function getPost($page_id) 
	{
		try {
			$access_token=$this->facebookappid."|".$this->facebookscret;			
			FacebookSession::setDefaultApplication($this->facebookappid, $this->facebookscret);
			$session = new FacebookSession($access_token);
			$post_query="/".$page_id."/feed?fields=".ActivitiesBase::POST_QUERY;
			$post_result=$this->FBrequest($session,$post_query);
			return $post_result;
			} catch (Exception $e) {
			echo $e->getMessage();
			}			
	}	
	
	/**
	 * Get the Comment details for the selected by using Post ID.
	 */
	public function getComments($post_id) 
	{	
		try {
			$access_token=$this->facebookappid."|".$this->facebookscret;			
			FacebookSession::setDefaultApplication($this->facebookappid, $this->facebookscret);
			$session = new FacebookSession($access_token);
			$comments_query="/".$post_id."/comments";
			$comments_result=$this->FBrequest($session,$comments_query);						
			return $comments_result;
			} catch (Exception $e) {
			echo $e->getMessage();
			}			
	}
	
	/**
	 * Get the Like details for the selected by using Post ID.
	 */
	public function getLikes($post_id) 
	{	
		try {
			$access_token=$this->facebookappid."|".$this->facebookscret;			
			FacebookSession::setDefaultApplication($this->facebookappid, $this->facebookscret);
			$session = new FacebookSession($access_token);
			$likes_query="/".$post_id."/likes";
			$likes_result=$this->FBrequest($session,$likes_query);						
			return $likes_result;
			} catch (Exception $e) {
			echo $e->getMessage();
			}			
	}
	
	public function FBrequest($session,$param) 
	{
		$request = new FacebookRequest($session, "GET", $param);
		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		$result = json_decode(json_encode($graphObject->asArray()), true);
		return $result;
	}

	
}