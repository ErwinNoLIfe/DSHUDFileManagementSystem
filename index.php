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
                $('#content').hide(1000,function(){
                $('#content').load(url);
                $('#content').show(1000,function(){});
                });
            }
            

        </script>
    </head>
    <body>
        <div id="wrap">
            <div id="header">
                <div id="logo">
                    <h1 style="text-align: center;color: white;"><span><img src="image/logo.png" alt="logo" style="width: 50px; height: auto;"/></span>Document File Storage</h1>  
                </div>
                </div>
            <div id="menu">
                <ul>
                <li><a href="#" onclick="getPage('User/Registration.php')">Registration</a></li>
                <li><a href="#">File Management</a>
                <ul>
                <li><a href="#" onclick="getPage('Folder/View.php')">Add New Folder</a></li>
                <li><a href="#" onclick="getPage('Upload/Upload.php')">Add New file</a></li>
                <li><a href="#" onclick="getPage('View/View.php')">View All file</a></li>
                <!--<li><a href="#">Edit file</a></li>-->
                </ul>
                </li> 
                <li><a href="logout.php">Logout</a></li>
                
                <li style="margin-top: 5px; margin-left: 10em;">
                    <form action="Search/SearchResults.php" method="get" style="display: flex; align-items: center;">
                        <input type="text" name="query" placeholder="Search files..." style="padding: 8px; border-radius: 4px; border: none; width: 200px; height: 30px;">
                        <button type="submit" style="margin-left: 5px; padding: 8px 15px; background-color: #0d4b8f; color: white; border: none; border-radius: 4px; cursor: pointer;">Search</button>
                    </form>
                </li>
                
                
                </ul>
            </div>
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
        <!-- Modal -->
<div class="modal fade" id="folderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Folder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input
          type="text"
          class="form-control"
          id="folderNameInput"
          placeholder="Folder name"
        />
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button class="btn btn-primary" id="createFolderBtn">
          Create
        </button>
      </div>
    </div>
  </div>
</div>

    </body>
    <script>
    function openFolderModal(onSubmit) {
  const modalEl = document.getElementById("folderModal");
  const modal = new bootstrap.Modal(modalEl);
  const input = document.getElementById("folderNameInput");
  const createBtn = document.getElementById("createFolderBtn");

  input.value = "";

  modalEl.addEventListener("shown.bs.modal", () => {
    input.focus();
  }, { once: true });

  createBtn.onclick = () => {
    const folderName = input.value.trim();
    if (!folderName) return;

    modal.hide();
    onSubmit(folderName);
  };

  modal.show();
}


    </script>
</html>
