
<?php
session_start();
include_once '../connection.php';
$sql = "SELECT
  a.fid,
  a.folder_name,
  COUNT(b.fid) AS upload_count,
  SUM(b.size) AS total_size
FROM folder a
LEFT JOIN upload b ON b.fid = a.fid
GROUP BY a.fid;
";
$res = mysqli_query($con, $sql) or die(mysqli_error($con));
$path = (isset($_SESSION['type']) && $_SESSION['type'] == 'Admin') ? "./" : "../";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Folders</title>
	<script src="folder_js.php"></script>
	<!-- JQuery, Popper, Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- DataTables JS -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="folder_css.php">
    <style type="text/css">
        #viewdata {
            border: 1px solid #aaa;
            margin-top: 1em;
            background: #fff;
        }
        #viewdata th {background: #aaa;}
        #viewdata td {background: #efefef;}
        #viewdata th, #viewdata td {padding: 8px; text-align: left;}
        .dropdown-menu a { color: #212121; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Folders</h1>
    <button class="btn btn-primary mb-3" id="addFolderBtn" onclick="folder_add()">Add Folder</button>
    <table id="viewdata" class="display table table-bordered table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>No. of Files</th>
                <th>Size (MB)</th>
                <th style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $a = 1;
        while($row = mysqli_fetch_assoc($res)) {
            $id = htmlspecialchars($row['fid']);
            $name = htmlspecialchars($row['folder_name']);
            $files = $row['upload_count'];
            $total_size_mb = ($row['total_size']) ? number_format($row['total_size'] / (1024*1024), 2) : "0.00";
            echo "<tr>
                    <td>{$a}</td>
                    <td>{$name}</td>
                    <td>{$files}</td>
                    <td>{$total_size_mb}</td>
                    <td>
                         <div style='padding: 5px; gap: 10px; display: flex; justify-content: center;' class='btn-group' role='group'>
                            <a class='btn btn-primary btn-sm' onclick='folder_file_add({$id})'><i class='fa fa-plus'></i></a>
                            <a class='btn btn-warning btn-sm edit-folder' href='{$path}View/edit.php?data={$id}'><i class='fa fa-edit'></i></a>
                            <a class='btn btn-info btn-sm' onclick='view_file_add({$id})'><i class='fa fa-eye'></i></a>
                            <a class='btn btn-success btn-sm' href='{$path}View/download.php?id={$id}'><i class='fa fa-download'></i></a>
							 <a class='btn btn-danger btn-sm del_doc' href='{$path}View/delete.php?data={$id}'><i class='fa fa-trash'></i></a>
                        </div>
                    </td>
                </tr>";
            $a++;
        }
        mysqli_close($con);
        ?>
        </tbody>
    </table>
</div>

<?php include_once '../inc/modal.php'; ?>

<script>


$(document).ready(function() {
    // Handle form submission
    $('#addFolderForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var formUrl = $(this).attr('action');

        // Hide error message
        $('#folderError').hide();

        $.ajax({
            url: formUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#addFolderModal').modal('hide');
                    $('#addFolderForm')[0].reset();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Folder added successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    $('#folderError').text(response.message || 'An error occurred while adding the folder.').show();
                }
            },
            error: function(xhr, status, error) {
                $('#folderError').text('An error occurred: ' + error).show();
            }
        });
    });

    // Clear form when modal is closed
    $('#addFolderModal').on('hidden.bs.modal', function() {
        $('#addFolderForm')[0].reset();
        $('#folderError').hide();
    });
});
$(document).ready(function() {
    // Init DataTable
    $('#viewdata').DataTable();

    // Add Folder click (you should link to an actual add form in prod)
    $('#addFolderBtn').click(function(e) {
        window.location.href = "<?php echo $path ?>View/add_folder.php";
    });

    // AJAX delete handler
    $('.del_doc').click(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this folder?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var loc = $(this).attr('href');
                $.ajax({
                    url: loc,
                    method: "POST",
                    error: function(err){
                        Swal.fire({
                            title: 'Error',
                            text: "An error occurred",
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.log(err);
                    },
                    success: function(resp){
                        if(resp == 1){
                            Swal.fire({
                                title: 'Deleted!',
                                text: "Folder successfully deleted",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: resp,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    });
});

function folder_add(){
    $('#addFolderModal').modal('show');
}

function folder_file_add(x){
    $('#viewFilesModal').modal('show');
}

function view_file_add(x){
	console.log("x", x);
	$('#folder_id').val(x);
	console.log($('#folder_id').val());
    $('#viewFilesModal').modal('show');
	viewFolderFiles(x, "sample namwe");
}

</script>
</body>
</html>

