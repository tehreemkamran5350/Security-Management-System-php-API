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
		window.flag=false;
		var table = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "userRoleTable"},
                    success: function (r) {
                        $("#table").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(table);
				var role = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getRoles","ed":0},
                    success: function (r) {
						$("#cmbRole").empty();
						var op='<option value=0>---select---</option>';
						$("#cmbRole").append(op);
                        $("#cmbRole").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(role);
				var user = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getUser","edu":0},
                    success: function (r) {
						$("#cmbUser").empty();
						var op='<option value=0>---select---</option>';
						$("#cmbUser").append(op);
                        $("#cmbUser").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(user);
				$("#save").click(function(){
				save();
				});
				 
		
	});
        function save(){	
if(flag==false){		
					 var obj={"flag":0,"act": "saveRoleUser","roleId":$("#cmbRole").val(),"userId":$("#cmbUser").val()};
					 var save = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:obj,
                    success: function (r) {
                        alert(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(save);
				  
				  }
		}
				  function editRoleUser(id)
            {
                 var obj={"act": "editRoleUser","ruid":id};
					 var edit = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:obj,
                    success: function (arr) {
						r=arr.split('~');
						var role = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getRoles","ed":r[0]},
                    success: function (c) {
						$("#cmbRole").empty();
                        $("#cmbRole").append(c);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(role);
					var user = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getUser","edu":r[1]},
                    success: function (r) {
						$("#cmbUser").empty();
                        $("#cmbUser").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(user);
                    },
                    error: function () {
                        alert("error has occured");	
                    }
                };
				
                $.ajax(edit);
				flag=true;	
			$("#save").click(function(){
				edSaveRoleUser(id);
				});
			
            }
            function edSaveRoleUser(id){	
		
					 var obj={"ruid":id,"flag":1,"act": "saveRoleUser","roleId":$("#cmbRole").val(),"userId":$("#cmbUser").val()};
					 var edsave = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:obj,
                    success: function (r) {
                        alert(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(edsave);
				 
			}
     function delRoleUser(id){
		  var del = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:{"act":"delRoleUser","ruid":id},
                    success: function (r) {
                        alert(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(del);
		 
	 }
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
        <div class="item1" id="div1">
            <div class="sidenav">
                <h1> User-Role Management</h1>
                <form>

                    Role<br>
                    <select name="" id="cmbRole"></select><br>

                    User:<br>
                    <select name="" id="cmbUser" required></select><br>

                    <input type=submit id="save" value="save">

                </form>
            </div>
        </div>
        <div class="item2">
            <div id="table"></div>

        </div>


</body>
</html>
<?php
	}}
?>