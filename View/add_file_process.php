<?php 
session_start();
include_once '../connection.php';

// Set content type to JSON for AJAX response
header('Content-Type: application/json');

// Check for the required POST data
if (
    isset($_POST['folder_id']) &&
    !empty($_POST['folder_id']) &&
    isset($_FILES['file']) &&
    $_FILES['file']['error'] === UPLOAD_ERR_OK
) {
    $folder_id = intval($_POST['folder_id']);

    // File properties
    $file = $_FILES['file'];
    $orig_name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $size = $file['size'];
    $type = $file['type'];

    // Validate folder id exists in db
    $folder_stmt = mysqli_prepare($con, "SELECT fid FROM folder WHERE fid = ?");
    mysqli_stmt_bind_param($folder_stmt, "i", $folder_id);
    mysqli_stmt_execute($folder_stmt);
    mysqli_stmt_store_result($folder_stmt);

    if (mysqli_stmt_num_rows($folder_stmt) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid folder selected.'
        ]);
        mysqli_stmt_close($folder_stmt);
        mysqli_close($con);
        exit;
    }
    mysqli_stmt_close($folder_stmt);

    // Securely determine upload path
    $uploadBaseDir = realpath(__DIR__ . '/../uploads');
    if (!$uploadBaseDir) {
        mkdir(__DIR__ . '/../uploads', 0777, true);
        $uploadBaseDir = realpath(__DIR__ . '/../uploads');
    }

    // Create folder-specific directory if it doesn't exist
    $folderUploadDir = $uploadBaseDir . DIRECTORY_SEPARATOR . $folder_id;
    if (!is_dir($folderUploadDir)) {
        mkdir($folderUploadDir, 0777, true);
    }
    // Prevent path traversal
    $targetFilename = basename($orig_name);
    $targetPath = $folderUploadDir . DIRECTORY_SEPARATOR . $targetFilename;
    // Check file already exists in folder
    if (file_exists($targetPath)) {
        echo json_encode([
            'success' => false,
            'message' => 'A file with this name already exists in the folder.'
        ]);
        mysqli_close($con);
        exit;
    }

    // Move file
    if (move_uploaded_file($tmp_name, $targetPath)) {
        // Save file information to database
        $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;
        $save_query = "INSERT INTO files (folder_id, file_name, file_size, file_type, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($con, $save_query);
        mysqli_stmt_bind_param($stmt, "isisi", $folder_id, $targetFilename, $size, $type, $user_id);
        $db_result = mysqli_stmt_execute($stmt);

        if ($db_result) {
            echo json_encode([
                'success' => true,
                'message' => 'File uploaded and saved successfully.',
                'file_id' => mysqli_insert_id($con),
                'file_name' => $targetFilename
            ]);
        } else {
            // Rollback file on disk if DB insert fails
            unlink($targetPath);
            echo json_encode([
                'success' => false,
                'message' => 'Error saving file information: ' . mysqli_error($con)
            ]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to move uploaded file.'
        ]);
    }
} else {
    // Required data missing
    $msg = '';
    if (!isset($_FILES['file'])) {
        $msg = 'No file uploaded.';
    } elseif ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $msg = 'File upload error (code ' . $_FILES['file']['error'] . ').';
    } elseif (!isset($_POST['folder_id']) || empty($_POST['folder_id'])) {
        $msg = 'Target folder not specified.';
    }
    echo json_encode([
        'success' => false,
        'message' => $msg ?: 'Required data missing.'
    ]);
}

mysqli_close($con);
?>
