
<?php
session_start();
include_once '../connection.php';
$sql="SELECT 
  a.fid,
  a.folder_name,
  COUNT(b.fid) AS upload_count,
  SUM(b.size) AS total_size
FROM folder a
LEFT JOIN upload b ON b.fid = a.fid
GROUP BY a.fid;
";
$res=mysqli_query($con,$sql) or die(mysqli_error($con));
?>
<html>
<head>
<style type="text/css">
#viewdata table{
    border:1px solid #aaa;
}
#viewdata th{background:#aaa;}
#viewdata td{background:#efefef;}
#viewdata th,td{padding:5px;text-align:left;}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<h1>Folders</h1>
<button class="btn btn-primary">Add Folder</button>
<table id="viewdata">
<tr>
<th>No. </th>
<th>Name</th>
<th>No. of Files</th>
<th>Size</th>

<th colspan=2>Action</th>
</tr>
<?php
$a = 1;
while($row=mysqli_fetch_assoc($res))
{
echo "<tr><td><input type='hidden' value='".$row['fid']."'/>";
echo $a++;
echo "</td><td>";
echo $row['folder_name'];
echo "</td><td>";
echo $row['upload_count'];
echo "</td><td>";
echo "</td><td>" . (number_format($row['total_size'] / (1024*1024),2)) . " MB</td>";
echo " Kb";
$path = ($_SESSION['type'] == 'Admin') ? "./" : "../";
echo "
<td>
<center><div class='dropdown eval_form_page_b'>
                    <button style='width:100%; border:none;' class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1EvalR' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
                        <i class='glyphicon glyphicon-option-vertical'></i>
                    </button>
                    <ul class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenu1EvalR'>
						<li class='eval_form_page_e' style='cursor:pointer;'><a href='".$path."View/view.php?data=".$row['fid']."' class='view_doc' onclick=''><i class='glyphicon glyphicon-edit'></i> Add File</a></li>
                        <li class='eval_form_page_e' style='cursor:pointer;'><a href='".$path."View/delete.php?data=".$row['fid']."' class='del_doc' onclick=''><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
						li class='eval_form_page_e' style='cursor:pointer;'><a onclick=''><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                        <li class='eval_form_page_d' style='cursor:pointer;'><a href='".$path."View/download.php?id=".$row['fid']."' onclick=''><i class='glyphicon glyphicon-trash'></i> Download</a></li>
                    </ul>
                </div>
</td>";
}$a++;
mysqli_close($con);
?>
</table>

<script>
	$(document).ready(function(){
		$('.del_doc').click(function(e){
			e.preventDefault();
			var loc = $(this).attr('href');
			$.ajax({
				url:loc,
				error:err=>{
					alert("An error occured");
					console.log(err)
				},
				success:function(resp){
					if(resp == 1){
						alert("File successfully deleted");
						getPage('<?php echo $path ?>View/View.php')
					}
				}
			})
		})
	})
</script>
