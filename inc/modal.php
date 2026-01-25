<!-- Add Folder Modal -->
<div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFolderModalLabel"><i class="fa fa-folder"></i> Add New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addFolderForm" method="POST" action="<?php echo $path; ?>View/add_folder_process.php">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="folder_name">Folder Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="folder_name" name="folder_name" placeholder="Enter folder name" required>
                        <small class="form-text text-muted">Please enter a unique folder name.</small>
                    </div>
                    <div id="folderError" class="alert alert-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveFolderBtn"><i class="fa fa-save"></i> Save Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Files in Folder Modal -->
<div class="modal fade" id="viewFilesModal" tabindex="-1" role="dialog" aria-labelledby="viewFilesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" id="folder_id" value="0">
                <h5 class="modal-title" id="viewFilesModalLabel"><i class="fa fa-folder-open"></i> Files in Folder: <span id="folderNameDisplay"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" id="addFileBtn" onclick="addFileToFolder()">
                        <i class="fa fa-plus"></i> Add File
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="filesTable" class="table table-bordered table-hover table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>File Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div id="filesError" class="alert alert-danger" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add File Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel"><i class="fa fa-file"></i> Add New File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addFileForm" method="POST" action="<?php echo $path; ?>View/add_file_process.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="addFileFolderId" name="folder_id" value="">
                    <div class="form-group">
                        <label for="file_name">File Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="file_name" name="file_name" placeholder="Enter file name" required>
                        <small class="form-text text-muted">You may leave blank to use the uploaded file's original name.</small>
                    </div>
                    <div class="form-group">
                        <label for="file_upload">Upload File <span style="color: red;">*</span></label>
                        <input type="file" class="form-control-file" id="file_upload" name="file_upload" required>
                        <small class="form-text text-muted">Allowed types: pdf, doc, docx, xls, xlsx, png, jpg, jpeg, txt, etc.</small>
                    </div>
                    <div id="fileError" class="alert alert-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveFileBtn"><i class="fa fa-save"></i> Save File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var filesDataTable = null;
var currentFolderId = null;

function viewFolderFiles(folderId, folderName) {
    currentFolderId = folderId;
    $('#folderNameDisplay').text(folderName);
    $('#viewFilesModal').modal('show');
    
    // Destroy existing DataTable if it exists
    if (filesDataTable) {
        filesDataTable.destroy();
        filesDataTable = null;
    }
    
    // Clear previous data
    $('#filesTable tbody').empty();
    $('#filesError').hide();
    
    // Load files via AJAX
    $.ajax({
        url: '<?php echo isset($path) ? $path : "../"; ?>View/get_folder_files.php',
        type: 'GET',
        data: { folder_id: folderId },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var tbody = $('#filesTable tbody');
                tbody.empty();
                
                if(response.files && response.files.length > 0) {
                    $.each(response.files, function(index, file) {
                        var sizeKB = (file.size / 1024).toFixed(2);
                        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        var sizeDisplay = sizeMB > 1 ? sizeMB + ' MB' : sizeKB + ' KB';
                        
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + file.name + '</td>' +
                            '<td>' + file.type + '</td>' +
                            '<td>' + sizeDisplay + '</td>' +
                            '<td>' +
                                '<div class="btn-group" role="group">' +
                                    '<a href="<?php echo isset($path) ? $path : "../"; ?>View/show_file.php?id=' + file.id + '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>' +
                                    '<a href="<?php echo isset($path) ? $path : "../"; ?>View/download.php?id=' + file.id + '" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>' +
                                    '<a href="<?php echo isset($path) ? $path : "../"; ?>View/delete.php?data=' + file.id + '" class="btn btn-danger btn-sm del_file"><i class="fa fa-trash"></i></a>' +
                                '</div>' +
                            '</td>' +
                        '</tr>';
                        tbody.append(row);
                    });
                    
                    // Initialize DataTable
                    filesDataTable = $('#filesTable').DataTable({
                        "pageLength": 10,
                        "order": [[0, "asc"]],
                        "language": {
                            "emptyTable": "No files in this folder"
                        }
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center">No files in this folder</td></tr>');
                    filesDataTable = $('#filesTable').DataTable({
                        "pageLength": 10,
                        "order": [[0, "asc"]]
                    });
                }
            } else {
                $('#filesError').text(response.message || 'Error loading files').show();
            }
        },
        error: function(xhr, status, error) {
            $('#filesError').text('Error loading files: ' + error).show();
        }
    });
}

function addFileToFolder() {
    var currentFolderId = $("#folder_id").val();
    console.log(currentFolderId);
    if(currentFolderId) {
    } else {
        alert('Please select a folder first');
    }
    $('#addFileModal').modal('show');


}

// Handle file deletion
$(document).on('click', '.del_file', function(e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this file?")) return false;
    
    var loc = $(this).attr('href');
    var row = $(this).closest('tr');
    
    $.ajax({
        url: loc,
        method: "POST",
        error: function(err){
            alert("An error occurred");
            console.log(err);
        },
        success: function(resp){
            if(resp == 1){
                alert("File successfully deleted");
                // Remove row from DataTable
                if(filesDataTable) {
                    filesDataTable.row(row).remove().draw();
                } else {
                    row.remove();
                }
            } else {
                alert(resp);
            }
        }
    });
});

// Clear DataTable when modal is closed
$('#viewFilesModal').on('hidden.bs.modal', function() {
    if(filesDataTable) {
        filesDataTable.destroy();
        filesDataTable = null;
    }
    currentFolderId = null;
});
</script>


