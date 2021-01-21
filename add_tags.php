<?php
require_once('connect.php');
session_start();
if(isset($_POST) && !empty($_POST)){
	
	$title = mysql_real_escape_string($_POST['title']);
	$description = mysql_real_escape_string($_POST['description']);

	$image_name = "";
	if(isset($_FILES['image'])){
		$image_name = $_FILES['image']['name']; 
		$image_ext  = pathinfo($image_name,PATHINFO_EXTENSION);
		$image_name  = basename($image_name,".".$image_ext);

		$image_name = $image_name.'_'.date('Y_m_d_H_i_s');
		$image_name = str_replace("", "_", $image_name).'.'.$image_ext;

		$tmp_name = $_FILES['image']['tmp_name'];

		if($tmp_name!=''){
			move_uploaded_file($tmp_name, "images/".$image_name);
		}
		
	}
	
	
	
	if($title!=''){
		$blogs_qry = "INSERT INTO blogs SET
						title='".$title."',
						description='".$description."',
						image='".$image_name."',
						user_id='".$_SESSION['user_id']."',
						created_at='".date('Y-m-d H:i:s')."'
						";
		$blogs_qry = mysql_query($blogs_qry);
		$last_id = mysql_insert_id();

		foreach ($_POST['name'] as $key => $value) {

			$blogs_tags_qry = "INSERT INTO blog_tags SET
						blog_id='".$last_id."',
						name='".$value."'
						
						";
		$blogs_tags_qry = mysql_query($blogs_tags_qry);
		}

		if($last_id>0){
			header('location:index.php');
		} 
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog Registration</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($){

		$("body").on("click",".add",function(e){
			var trobj = $('.add_wraps').html();
			var add_btn = $('.add_btn').html();
			console.log(add_btn);
			var minus = '<button type="button" class="minus">-</button>';
			$('.tag_class').append('<tr class="add_wraps"><td></td><td>'+trobj+'</td>'+minus+'</tr>');
			$('.add_btn').remove();
			$('.tag_class').append(add_btn);
		});

		$('#user_tag').submit(function(){
			var title = $('#title').val();
			var description = $('#description').val();
			var image = $('#image').val();
			var ext = "";
			if($('#image')[0].files.length>0){
				var ext = image.split('.').pop().toLowerCase();
				var size = Math.round($('#image')[0].files[0].size/1024);
			}
			var arr = [ "jpg","png" ,"jpeg" ];
			var is_found = jQuery.inArray( ext, arr );
			if(title.trim()==''){
				alert("Please enter title");
				return false;
			}else if(description.trim()==''){
				alert("Please enter description");
				return false;
			}else if(image==''){
				alert("Please select image");
				return false;
			}else if(ext!='' && is_found==-1){
				alert("Please upload image only");
				return false;
			
			}else{
				return true;
				
			}
		});
	});
</script>
</head>
<body>
<?php 
if(!empty($_REQUEST) && $_REQUEST['id']!=''){
	$tags_qry = "SELECT * FROM blogs WHERE id='".$_REQUEST['id']."'";
	$tags_res = mysql_query($tags_qry);
	$tags_row = mysql_fetch_array($tags_res);

	$all_tags_qry = "SELECT * FROM blog_tags WHERE blog_id='".$_REQUEST['id']."'";
	$all_tags_res = mysql_query($all_tags_qry);
	
}

?>
	<form method="post" name="user_tag" id="user_tag" enctype="multipart/form-data">
	<table class="tag_class">
		
		<tr>
			<td>Title</td>
			<td><input type="text" name="title" id="title" value="<?php echo (!empty($_REQUEST)) ? $tags_row['title']:''; ?>"></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><textarea name="description" id="description"><?php echo (!empty($_REQUEST)) ? $tags_row['title']: ''; ?></textarea></td>
		</tr>
		<tr>
			<td>Image</td>
			<td><input type="file" name="image" id="image"> <?php if(!empty($_REQUEST)){ $image =  "images/".$tags_row['image'];  ?><image src="<?php echo $image;?>" width="100" height="100"><?php } ?></td>
		</tr>

		<tr>
			<td>Tag</td>
			<td>
				
				<div class="add_wraps">
					<?php if(!empty($_REQUEST) && $_REQUEST['id']!='') {
			while ($all_tags_row = mysql_fetch_array($all_tags_res)) {
				# code...
			
			?>
					<input type="text" name="name[]" id="name" value="<?php echo $all_tags_row['name']; ?>">
				</div> 
				<?php }

			}else{  ?>
				<input type="text" name="name[]" id="name" >
			<?php }?>
				<div class="add_btn">
				<button type="button" class="add">+</button></td>
				</div> 
		</tr>
		
		
	</table>
	<table>
		
			<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="tag_submit" id="tag_submit" value="submit"></td>
		
		</tr>
	</table>
	</form>
</body>
</html>

