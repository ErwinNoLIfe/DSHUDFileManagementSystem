<!DOCTYPE html>
<html>
<head>
<title>Docs | Login</title>
<link rel="stylesheet" href="../css/login.css">
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
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
    <img src="../image/logo.png" alt="DHSUD Logo" style="height: 70px; margin-right: 20px;">
<h2>DHSUD-R5</h2>
</div>
</div>

<div id="content">
    <form name="Myform" id="Myform" action="loginProcess.php" method="post" onsubmit="return(Validate());">
   <div id="error" style="color:red; font-size:16px; font-weight:bold; padding:5px"></div>
    <table style="width:100px; margin-left:2em;">
        <thead></thead>
        <tbody>
            <tr>
                <td style="text-align: right;font-size: 20px">Username</td>
                <td style="font-size: 20px"><input type="text" name="uname" id="fname" onkeydown="HideError()" size="20px;" style="height: 30px;"/></td>
            </tr>
            <tr>
                <td style="text-align: right;font-size: 20px">Password</td>
                <td style="font-size: 24px"><input type="password" name="password" id="password" onkeydown="HideError()" size="20px;" style="height: 30px;"/></td>
            </tr>
            
            <tr>
         
                <td colspan="2" style="text-align: center; margin-top: 100%;"><input type="submit" name="submit" value="Login" style="width: 150px; height: 40px; font-size: 20px; background-color: #156abe; color: white; border: none; border-radius: 5px; cursor: pointer;" /></td>
            </tr>
            <tr>
                
                <td style="text-align: center;"><a href="#" onclick="getPage('forgetPassword.php')" style="color: #156abe; text-decoration: none;"><i>Forgot Password?</i></a></td>
            </tr>
        
        </tbody>
    </table>
</form>

</div>

<div class= "clear"></div>

<div id="footer">
DHSUD-R5 2025
</div>
</div>
</body>
</html>
