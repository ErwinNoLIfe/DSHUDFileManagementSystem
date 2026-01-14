<?php
    include_once 'AdminSession.php';
    $uname = $_SESSION['email'];
    $password = $_SESSION['password'];
    $chekUser = mysqli_query($con,"Select * from user where email= '$uname' AND password = '$password'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($chekUser);
    $fname = $row['fname'];
    $lname = $row['lname'];
    
    $username = $fname . " ".$lname;
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Docs | Home Page</title>
        <link rel="stylesheet" href="css/index.css">
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/Registration.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            function getPage(url){
              $('#content').load(url);
            }
            

        </script>
    </head>
    <body>
        <div id="wrap">
            <!-- Bootstrap Navbar Top Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
              <a class="navbar-brand d-flex align-items-center" href="#" style="font-size: 1.35rem;">
                <img src="image/logo.png" alt="logo" style="width: 50px; height: auto; margin-right: 0.75em;"/>
                Document File Storage
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="#" onclick="getPage('User/Registration.php')">Registration</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">File Management</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#" onclick="getPage('Folder/View.php')">Add New Folder</a>
                      <a class="dropdown-item" href="#" onclick="getPage('Upload/Upload.php')">Add New File</a>
                      <a class="dropdown-item" href="#" onclick="getPage('View/View.php')">View All File</a>
                    </div>
                  </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 mr-3" action="Search/SearchResults.php" method="get">
                  <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search files..." aria-label="Search">
                  <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
                <a class="btn btn-outline-light" href="logout.php">Logout</a>
              </div>
            </nav>
            <!-- End Navbar -->

            <div id="main">
            <div id="content">
            <h1>Welcome to docsystem </h1>
            <ul style="margin-left: 5em; margin-top: 2em;">
                <li>Upload files to the system</li>
                <li>Download your files wherever you are</li>
                <li>Edit your personal files</li>
                <li>Register new user</li>
                <li>Edit registered users</li>
            </ul>
            </div>
            <div id="side">
            <h3>Dashboard</h3>
            <table style="border: 1px black solid;background-color: #607B8B;">
                <tr>
                    <td><li><a href="#" onclick="getPage('Upload/Upload.php')">Add New file</a></li></td>
                </tr>
                <tr>
                    <td><li><a href="#" onclick="getPage('View/View.php')">View file</a></li></td>
                </tr>
                <tr>
                    <td><li><a href="#" onclick="getPage('User/Registration.php')">Add user</a></li></td>
                </tr>
                <tr>
                    <td><li><a href="#" onclick="getPage('User/ViewUser.php')">View Users</a></li></td>
                </tr>

            </table>
            </div>
            <!-- this clear class is for special purpose.
            this is for to clear the "float property" of 
            the previous element, it will prevent footer
            to float -->
            <div class= "clear"></div>
            </div>
            <div id="footer">
            DHSUD-R5 2025
            </div>
        </div>
        
      </body>

    </script>
</html>
