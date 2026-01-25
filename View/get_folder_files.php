<?php
session_start();
include_once '../connection.php';

header('Content-Type: application/json');

if(isset($_GET['folder_id'])) {
    $folder_id = intval($_GET['folder_id']);
    
    // Query to get files in the folder
    $sql = "SELECT id, name, type, size, fid FROM upload WHERE fid = '$folder_id' ORDER BY id DESC";
    $res = mysqli_query($con, $sql);
    
    if($res) {
        $files = array();
        while($row = mysqli_fetch_assoc($res)) {
            $files[] = array(
                'id' => $row['id'],
                'name' => htmlspecialchars($row['name']),
                'type' => htmlspecialchars($row['type']),
                'size' => intval($row['size']),
                'fid' => intval($row['fid'])
            );
        }
        
        echo json_encode(array(
            'success' => true,
            'files' => $files,
            'count' => count($files)
        ));
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Error querying database: ' . mysqli_error($con)
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'Folder ID not provided'
    ));
}

mysqli_close($con);
?>
