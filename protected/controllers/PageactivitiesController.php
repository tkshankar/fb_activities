<?php

class PageactivitiesController extends ActivitiesBase
{

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render('index');		
	}
	
	/**
	 * Pull data from Post(Feed) table to construct CSV for the selected page id.
	 */
	public function actionExptFeed($page_id)
	{
		$feedObj = Feed::model()->findAllPost($page_id);
		$fileName="Feed_".$page_id;			
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$fileName.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "Page ID,Post ID,From Name,Category,From ID,Page Owner,To Name,To Category,To ID,Message,Likes Count,Comments Count,Created Date/Time,Updated Date/Time,Data Aquired Date/Time\n";	
			foreach ($feedObj as $data) { 
			$page_owner=$data['page_owner']==1?"Yes":"No";
			echo $data['page_id'].",".$data['post_id'].",".$data['from_name'].",".$data['from_category'].",".$data['from_id'].",".$page_owner.",".$data['to_name'].",".$data['to_categerory'].",".$data['to_id'].",".$data['message'].",".$data['likes_count'].",".$data['comments_count'].",".$data['created_time'].",".$data['updated_time'].",".$data['data_aquired_time']."\n";
			}	
	}
	
	/**
	 * Pull data from comments table to construct CSV for the selected page id.
	 */
	public function actionExptComments($page_id)
	{
		$commentObj = Comment::model()->findAllcomments($page_id);
		$fileName="Comments_".$page_id;	
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$fileName.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "Page ID,Post ID,User ID,User Name,Message,Created Date/Time\n";	
			foreach ($commentObj as $data) { 
			echo $data['page_id'].",".$data['post_id'].",".$data['from_id'].",".$data['from_name'].",".$data['message'].",".$data['created_time']."\n";
			}	
	}
	
	/**
	 * Pull data likes table to construct CSV for the selected page id.
	 */
	public function actionExptLikes($page_id)
	{
		$LikeObj = Like::model()->findAllLikes($page_id);
		$fileName="Likes_".$page_id;			
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$fileName.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "Page ID,Post ID,User ID,User Name\n";	
			foreach ($LikeObj as $data) { 
			echo $data['page_id'].",".$data['post_id'].",".$data['user_id'].",".$data['user_name']."\n";
			}	
	}
		
	/**
	 * Displays a particular model.
	 */
	public function actionProcessPost()
	{		
		$pageinfo=Yii::app()->request->getPost('page_det');					
						$page_result = $this->getPage($pageinfo);
						if(!empty($page_result)) {	
								$page_id=$page_result['id'];
								$post_result = $this->getPost($page_id);
												
								if (!empty($post_result['data'])) {
									foreach ($post_result['data'] as $pagepost) {
									$this->saveFeed($page_id, $pagepost);
											
											if((isset($pagepost['comments']['data'])) && (!empty($pagepost['comments']['data'])) ) {
											$comments_result =$this->getComments($pagepost['id']);							
												if (!empty($comments_result['data'])) {
													foreach ($comments_result['data'] as $comments_data) {
														$this->saveComments($page_id,$pagepost['id'], $comments_data);
													}
												}
											}
											
											if((isset($pagepost['likes']['data'])) && (!empty($pagepost['likes']['data'])) ) {
											$likes_result =$this->getLikes($pagepost['id']);							
												if (!empty($likes_result['data'])) {
													foreach ($likes_result['data'] as $likes_data) {
														$this->saveLikes($page_id,$pagepost['id'], $likes_data);
													}
												}
											}								
										}
								$this->render("feed_display",array("post_result"=>$post_result['data'],"page_id"=>$page_id));		
								}
																
								
								
							} else {
								$errormesage="Page Name / ID you enter '".$pageinfo."' is Invalid";
								$this->render("error_display",array("message"=>$errormesage));
								}
						

						
				
	}
	
	/**
	 * Creates a new post(Feed).
	 * This method attempts to create a new post(feed) based on the user input page name or ID.
	 * If the comment is already exist, It will update with the existing record record otherwise create new record
	 */
	public function saveFeed($pageid, $postdata = false) {	
	
				if (isset($postdata['id'])) {
				$feedObj = Feed::model()->findByPostId($postdata['id']);				
				
				if(empty($feedObj)) {
				$feedObj=new Feed();
				}
				
				$feedObj->page_id = $pageid;
				$feedObj->post_id = $postdata['id'];
				
				$feedObj->from_name = $postdata['from']['name'];
				$feedObj->from_category = $postdata['from']['category'];
				$feedObj->from_id = $postdata['from']['id'];
				$feedObj->page_owner = ($postdata['from']['id'] == $pageid) ? 1 : 0;
				
				$feedObj->to_name = isset($postdata['to']) ? $postdata['to'] : "";
				$feedObj->to_categerory = isset($postdata['to']['category']) ? $postdata['to']['category'] : "";
				$feedObj->to_id = isset($postdata['to']['id']) ? $postdata['to']['id'] : "";
				
				$feedObj->message = isset($postdata['message']) ? $postdata['message'] : "";
				$feedObj->message_tags = isset($postdata['message_tags']) ? $postdata['message_tags'] : "";

				$feedObj->picture = isset($postdata['picture']) ? $postdata['picture'] : "";
				$feedObj->link = isset($postdata['link']) ? $postdata['link'] : "";
				$feedObj->name = isset($postdata['name']) ? $postdata['name'] : "";
				$feedObj->caption = isset($postdata['caption']) ? $postdata['caption'] : "";
				$feedObj->description = isset($postdata['description']) ? $postdata['description'] : "";		
				$feedObj->source = isset($postdata['source']) ? $postdata['source'] : "";
				$feedObj->properties = isset($postdata['properties']) ? $postdata['properties'] : "";
				$feedObj->icon = isset($postdata['icon']) ? $postdata['icon'] : "";
				$feedObj->type = isset($postdata['type']) ? $postdata['type'] : "";
				$feedObj->place = isset($postdata['place']) ? $postdata['place'] : "";		
				$feedObj->story = isset($postdata['story']) ? $postdata['story'] : "";
				$feedObj->story_tags = isset($postdata['story_tags']) ? $postdata['story_tags'] : "";
				
				$feedObj->object_id = isset($postdata['object_id']) ? $postdata['object_id'] : "";
				$feedObj->application_name = isset($postdata['application']) ? $postdata['application']['name'] : "";
				$feedObj->application_id = isset($postdata['application']['id']) ? $postdata['application']['id'] : "";
				
				$feedObj->likes_count = isset($postdata['likes']['summary']['total_count']) ? $postdata['likes']['summary']['total_count'] : "";
				$feedObj->comments_count = isset($postdata['comments']['summary']['total_count']) ? $postdata['comments']['summary']['total_count'] : "";
				
				$feedObj->created_time = $postdata['created_time'];
				$feedObj->updated_time = $postdata['updated_time'];
				$feedObj->data_aquired_time = date("Y-m-d H:i:s");
				try {
					if (!$feedObj->save()) {				
					}
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}	
	}
	
	/**
	 * Creates a new comments.
	 * This method attempts to create a new post(feed) based on the user input page name or ID and post ID.
	 * If the comment is already exist, It will update with the existing record record otherwise create new record
	 */
	public function saveComments($page_id,$post_id, $comments_data = false) 
	{	
		if (isset($comments_data['id'])) {
			$commentObj = Comment::model()->findByCommentId($comments_data['id']);				
			
			if(empty($commentsObj)) {
			$commentObj=new Comment();
			}
			
			$commentObj->page_id = $page_id;
			$commentObj->post_id = $post_id;
			$commentObj->comment_id = $comments_data['id'];
			$commentObj->from_id = $comments_data['from']['id'];
			$commentObj->from_name = $comments_data['from']['name'];
			$commentObj->message = isset($comments_data['message']) ? $comments_data['message'] : "";				
			$commentObj->created_time = $comments_data['created_time'];
			$commentObj->data_aquired_time = date("Y-m-d H:i:s");
			try {
				if (!$commentObj->save()) {				
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}	
	}
	
	/**
	 * Creates a new Likes.
	 * This method attempts to create a new likes based on the user input page name or ID and User ID.
	 * If the like is already exist, It will update with the existing record record otherwise create new record
	 */
	public function saveLikes($page_id,$post_id, $likes_data = false) 
	{	
		if (isset($likes_data['id'])) {
			$likeObj = Like::model()->findByLikeId($post_id,$likes_data['id']);				
			
			if(empty($likeObj)) {
			$likeObj=new Like();
			}
			
			$likeObj->page_id = $page_id;
			$likeObj->post_id = $post_id;
			$likeObj->user_id = $likes_data['id'];
			$likeObj->user_name = $likes_data['name'];
			$likeObj->data_aquired_time = date("Y-m-d H:i:s");
			try {
				if (!$likeObj->save()) {				
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}	
	}
	
}
