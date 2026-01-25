<?php 
session_start();
include_once '../connection.php';

// Set content type to JSON for AJAX response
header('Content-Type: application/json');

if(isset($_POST['folder_name'])){
    $folder_name = trim(htmlentities(stripslashes(mysqli_real_escape_string($con, $_POST['folder_name']))));
    
    // Validate folder name
    if(empty($folder_name)){
        echo json_encode(array(
            'success' => false,
            'message' => 'Folder name is required'
        ));
        exit;
    }
    
    // Check if folder name already exists
    $check_query = "SELECT fid FROM folder WHERE folder_name = '$folder_name'";
    $check_result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($check_result) > 0){
        echo json_encode(array(
            'success' => false,
            'message' => 'Folder name already exists. Please choose a different name.'
        ));
        exit;
    }
    
    // Get user ID from session if available
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;
    
    // Insert new folder
    $insert_query = "INSERT INTO folder (folder_name, user_id) VALUES ('$folder_name', " . ($user_id ? $user_id : 'NULL') . ")";
    $insert_result = mysqli_query($con, $insert_query);
    
    if($insert_result){
        echo json_encode(array(
            'success' => true,
            'message' => 'Folder created successfully',
            'folder_id' => mysqli_insert_id($con),
            'folder_name' => $folder_name
        ));
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Error creating folder: ' . mysqli_error($con)
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'Folder name not provided'
    ));
}

mysqli_close($con);
?>
