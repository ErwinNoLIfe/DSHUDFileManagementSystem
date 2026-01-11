
<?php
session_start();
include_once '../connection.php';
$sql="SELECT * FROM upload";
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
<table id="viewdata">
<tr>
<th>Id</th>
<th>Name</th>
<th>Size</th>

<th colspan=2>Action</th>
</tr>
<?php
while($row=mysqli_fetch_assoc($res))
{
echo "<tr><td>";
echo $row['id'];
echo "</td><td>";
echo $row['name'];
echo "</td><td>";
echo number_format(($row['size']/1024),2) . " Kb";
$path = ($_SESSION['type'] == 'Admin') ? "./" : "../";
echo "
<td>
<center><div class='dropdown eval_form_page_b'>
                    <button style='width:100%; border:none;' class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1EvalR' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
                        <i class='glyphicon glyphicon-option-vertical'></i>
                    </button>
                    <ul class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenu1EvalR'>
                
                        <li class='eval_form_page_e' style='cursor:pointer;'><a onclick=''><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
						li class='eval_form_page_e' style='cursor:pointer;'><a onclick=''><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                        <li class='eval_form_page_d' style='cursor:pointer;'><a onclick=''><i class='glyphicon glyphicon-trash'></i> Delete</a></li>
                    </ul>
                </div>
</td>
<td><a href='".$path."View/view.php?data=".$row['id']."' class='view_doc'>View</a></td>
<td><a href='".$path."View/delete.php?data=".$row['id']."' class='del_doc'>delete</a></td>
<td><a href='".$path."View/download.php?id=".$row['id']."'>download</a></td></tr>";
}
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
