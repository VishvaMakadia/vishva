<?php 
if($_REQUEST['id']!=''){
	$tags_qry = "DELETE FROM blog_tags WHERE blog_id='".$_REQUEST['id']."'";
	$tags_res = mysql_query($tags_qry);

	$blogs_qry = "DELETE FROM blogs WHERE id='".$_REQUEST['id']."'";
	$blogs_res = mysql_query($blogs_qry);
	

	
	
}

?>