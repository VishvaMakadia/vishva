<?php
require_once('connect.php');
session_start();
//if (isset(var))

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Blog Management</title>
	</head>

	<body>
		<table>
			<?php if(!isset($_SESSION)){ ?>
			<tr>
				<td><a href="login.php">Login|</a></td>
				<td><a href="registration.php">Registration</a></td>
			</tr>
			<?php } ?>
		</table>

		<a href="add_tags.php">Add</a>
		<table border="1">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Description</th>
					<th>Tags</th>
					<?php if($_SESSION['user_id']>0){ ?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				 $blogs_qry = "SELECT id, user_id,title,description,image FROM blogs";
				$blogs_res = mysql_query($blogs_qry);
				$total_blogs = mysql_num_rows($blogs_res);

				if($total_blogs > 0){
					while($blogs_row = mysql_fetch_array($blogs_res)){

						 	$tags_qry = "SELECT GROUP_CONCAT(name) as tags FROM blog_tags WHERE blog_id='".$blogs_row['id']."' GROUP BY blog_id";
						$tags_res = mysql_query($tags_qry);
						$tags_row = mysql_fetch_array($tags_res);
				?>
				<tr>
					<td><?php $image =  "images/".$blogs_row['image']; ?><image src="<?php echo $image;?>" width="100" height="100"></td>
					<td><?php echo $blogs_row['title']; ?></td>
					<td><?php echo $blogs_row['description']; ?></td>
					<td><?php echo $tags_row['tags']; ?></td>
					<?php if($blogs_row['user_id'] == $_SESSION['user_id']){?>
					<td><a href="add_tags.php?id=<?php echo $blogs_row['id']; ?>">Edit</a> <a href="delete_tags.php?id=<?php echo $blogs_row['id']; ?>">Delete</a></td>
					<?php } ?>
					
				</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</body>
</html>
