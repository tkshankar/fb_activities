<table border="1" width="40%" cellspacing='0' align="center">
<tr><td><a href="<?php echo Yii::app()->request->baseUrl; ?>/pageactivities/exptfeed/page_id/<?php echo $page_id;?>"><strong>Export Post</strong></a> (CSV)</td><td><a href="<?php echo Yii::app()->request->baseUrl; ?>/pageactivities/exptcomments/page_id/<?php echo $page_id;?>"><strong>Export Comments</strong></a>   (CSV)</td> <td><a href="<?php echo Yii::app()->request->baseUrl; ?>/pageactivities/exptlikes/page_id/<?php echo $page_id;?>"><strong>Export Likes</strong></a> (CSV)</td></tr>
</table>
<table border="1" width="98%" cellspacing='0' align="center">



	<tr><th>Page ID</th><th>Post ID</th><th>From Name</th><th>Category</th><th>From ID</th><th>Page Owner</th><th>To Name</th><th>To Category</th><th>To ID</th><th>Message</th><th>Likes Count</th><th>Comments Count</th><th>Created Date/Time</th><th>Updated Date/Time</th></tr>
<?php

foreach ($post_result as $pagepost) {

				
				$post_id = $pagepost['id'];
				$post_fromname = isset($pagepost['from']['name']) ? $pagepost['from']['name'] : "";
				$post_fromcategory = isset($pagepost['from']['category']) ? $pagepost['from']['category'] : "";
				$post_fromid = isset($pagepost['from']['id']) ? $pagepost['from']['id'] : "";
				
				//$page_owner=isset($pagepost['page_owner'])?"Yes":"No";
				
				$page_owner = ($pagepost['from']['id'] == $page_id) ? "Yes":"No";
				
				$post_toname = isset($pagepost['to']) ? $pagepost['to'] : "";
				$post_tocategory = isset($pagepost['to']['category']) ? $pagepost['to']['category'] : "";
				$post_toid = isset($pagepost['to']['id']) ? $pagepost['to']['id'] : "";
				
				$message = isset($pagepost['message']) ? $pagepost['message'] : "";
				
				
				$likes_count=isset($pagepost['likes']['summary']['total_count']) ? $pagepost['likes']['summary']['total_count'] : "";
				$comments_count=isset($pagepost['comments']['summary']['total_count']) ? $pagepost['comments']['summary']['total_count'] : "";
				
				$created_time = isset($pagepost['created_time']) ? $pagepost['created_time'] : "";
				$updated_time = isset($pagepost['updated_time']) ? $pagepost['updated_time'] : "";
				
				
				echo "<tr><td>$page_id</td><td>$post_id</td><td>$post_fromname</td><td>$post_fromcategory</td><td>$post_fromid</td><td>$page_owner</td><td>$post_toname</td><td>$post_tocategory</td><td>$post_toid</td><td>$message</td><td>$likes_count</td><td>$comments_count</td><td>$created_time</td><td>$updated_time</td></tr>";
}

?>
</table>

