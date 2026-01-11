<?php
session_start();
include_once '../connection.php';

// Check if search query is provided
if(isset($_GET['query']) && !empty($_GET['query'])) {
    $search_query = mysqli_real_escape_string($con, $_GET['query']);
    
    // Search in the upload table
    $sql = "SELECT * FROM upload WHERE name LIKE '%$search_query%'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    
    // Get the number of results
    $num_results = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Docs | Search Results</title>
    <link rel="stylesheet" href="../css/index.css">
    <style type="text/css">
        #search-results {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        #search-results th {
            background-color: #0d4b8f;
            color: white;
            padding: 10px;
            text-align: left;
        }
        #search-results td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        #search-results tr:hover {
            background-color: #f5f5f5;
        }
        .search-summary {
            margin: 20px 0;
            font-size: 16px;
        }
        .no-results {
            text-align: center;
            margin: 30px 0;
            font-size: 18px;
            color: #666;
        }
        .back-link {
            display: inline-block;
            margin: 20px 0;
            color: #0d4b8f;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="wrap">
        <div id="header">
            <div id="logo">
                <h1 style="text-align: center;color: white;"><span><img src="../image/logo.png" alt="logo" style="width: 50px; height: auto;"/></span>Document File Storage</h1>  
            </div>
        </div>
        
        <div id="main">
            <div id="content">
                <h1>Search Results</h1>
                
                <a href="../index.php" class="back-link">← Back to Home</a>
                
                <div class="search-summary">
                    <?php if($num_results > 0): ?>
                        Found <?php echo $num_results; ?> result(s) for "<?php echo htmlspecialchars($_GET['query']); ?>"
                    <?php else: ?>
                        <div class="no-results">
                            No results found for "<?php echo htmlspecialchars($_GET['query']); ?>"
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($num_results > 0): ?>
                <table id="search-results">
                    <tr>
                        <th>ID</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . number_format(($row['size']/1024), 2) . " KB</td>";
                        $path = ($_SESSION['type'] == 'Admin') ? "./" : "../";
                        echo "<td>";
                        echo "<a href='" . $path . "View/download.php?id=" . $row['id'] . "' style='color: #0d4b8f; text-decoration: none; margin-right: 10px;'>Download</a>";
                        if($_SESSION['type'] == 'Admin') {
                            echo "<a href='" . $path . "View/delete.php?data=" . $row['id'] . "' class='del_doc' style='color: #0d4b8f; text-decoration: none;'>Delete</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php endif; ?>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="footer">
            DHSUD-R5 2025
        </div>
    </div>
    
    <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.del_doc').click(function(e){
                e.preventDefault();
                var loc = $(this).attr('href');
                $.ajax({
                    url: loc,
                    error: function(err) {
                        alert("An error occurred");
                        console.log(err);
                    },
                    success: function(resp) {
                        if(resp == 1) {
                            alert("File successfully deleted");
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php
} else {
    // Redirect to home page if no search query is provided
    header("Location: ../index.php");
    exit();
}
?> 