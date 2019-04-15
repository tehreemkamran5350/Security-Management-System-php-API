<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
	if(isset($_SESSION["user"]) == true){
	if($_SESSION["isadmin"]==1){
		?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>userRoleManangement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

            * {
                box-sizing: border-box;
                font-family: Arial, Helvetica, sans-serif;
            }

            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }


            .topnav {
                overflow: hidden;
                background-color: #333;
            }

            /* Style the topnav links */
            .topnav a {
                float: left;
                display: block;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            /* Change color on hover */
            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }

            /* Style the content */
            .content {
                background-color: #ddd;
                padding: 10px;
                height: 200px; 
            }
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;

            }

            .grid-container {
                display: grid;
                grid-template-columns: auto auto auto auto auto auto auto auto;
                grid-gap: 10px;
                background-color: white;
                padding: 1px;
            }
            .grid-container > div {
                background-color: gainsboro;

                padding: 0px 0;

            }
            .item1 {
                grid-row: 1/4;

            }
            .item2 {
                grid-row: 1/4;

            }
            h1 {
                color: white;
                background-color:rgb(60, 60, 60)
            }
table, th, td {
    border: 1px solid black;
        </style>
<script src="jquery-3.2.1.min.js" type="text/javascript"></script>

    <script>
	$(document).ready(function () {
		var table = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "loginHistory"},
                    success: function (r) {
                        $("#table").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(table);
	});
    </script>
</head>
<body>

    <div class="topnav">
        <a href="home.php" >Home</a>
	  <a href="User_Mangement.php" >User Management</a>
	     <a href="Role_Mangement.php" >Role Management</a>
	    <a href="Permission_Mangement.php" >Permissions Management</a>
	   <a href="Role_Permission.php">Role-Permissions Assignment</a>
	<a href="User_Role.php">User-Role Assignment</a>
	  <a href="Login_History.php">Login History</a>
	   <a href="login.php" >Logout</a>

    </div>




    <div class="grid-container">
        <div class="item2">
            <div id="table"></div>

        </div>


</body>
</html>
<?php
	}}
?>