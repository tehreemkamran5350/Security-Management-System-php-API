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
        <title>userManangement</title>
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
                    data:  {"act": "userTable"},
                    success: function (r) {
                        $("#table").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(table);
				
				
                var countries = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getCountries","ed":0},
                    success: function (r) {
						$("#cmbCountries").empty();
						var op='<option value=0>---select---</option>';
						$("#cmbCountries").append(op);
                        $("#cmbCountries").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(countries);
				 $("#cmbCountries").change(function(){
					 var cities = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getCities","countryId":$("#cmbCountries").val(),"edCity":0},
                    success: function (r) {
						$("#cmbCities").empty();
						
						
                        $("#cmbCities").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(cities);
				 });
				 
				 $("#save").click(function(){
				save();
				});
				                               			 
				 
            });
                  function save(){	
			if(flag==false){	
			if($("#name").val=="" || $("#login").val=="" || $("#pswd").val=="" || $("#email").val=="" || $("#cmbCountries").val==""){
					alert("fill all the fields!");
				}
				else{
					var c=0;
					if ($("#chk").is(":checked")){
						c=1;
					}
					 var obj={"uid":0,"flag":0,"act": "saveUser","countryId":$("#cmbCountries").val(),"cityId":$("#cmbCities").val(),"name":$("#name").val(),"login":$("#login").val(),"pswd":$("#pswd").val(),"email":$("#email").val(),"isAdmin":c};
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
}
				  
            function editUser(id)
            {
                 var obj={"act": "editUser","userId":id};
					 var edit = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:obj,
                    success: function (arr) {
						r=arr.split('~');
						var countries = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getCountries","ed":r[0]},
                    success: function (c) {
						$("#cmbCountries").empty();
                        $("#cmbCountries").append(c);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(countries);
					var cities = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:  {"act": "getCities","countryId":r[0],"edCity":r[1]},
                    success: function (r) {
						$("#cmbCities").empty();
                        $("#cmbCities").append(r);
                    },
                    error: function () {
                        alert("error has occured");
                    }
                };
                $.ajax(cities);
						
						$("#name").val(r[2]);
						$("#login").val(r[3]);
						$("#pswd").val(r[4]);
						$("#email").val(r[5])
						if(r[6]==1){
						$("#chk").attr('checked',true);
						}
						if(r[6]==0){
							$("#chk").attr('checked',false);
						}
                    },
                    error: function () {
                        alert("error has occured");	
                    }
                };
				
                $.ajax(edit);
				flag=true;	
			$("#save").click(function(){
				edSaveUser(id);
				});
			
            }
            function edSaveUser(id){
								
					var obj={"uid":id,"flag":1,"act": "saveUser","countryId":$("#cmbCountries").val(),"cityId":$("#cmbCities").val(),"name":$("#name").val(),"login":$("#login").val(),"pswd":$("#pswd").val(),"email":$("#email").val(),"isAdmin":$("#chk").val()};
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
     function deleteUser(id){
		  var del = {
                    type: "POST",
                    datatype: "json",
                    url: "api.php",
                    data:{"act":"delUser","did":id},
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
                    <h1> User Management</h1>
                    <form>

                        Login:<br>
                        <input type=text id="login" ><br>
                        Password:<br>
                        <input type=password id="pswd" ><br>
                        Name:<br>
                        <input type=text id="name" ><br>
                        Email:<br>
                        <input type=text id="email"><br>
                        Country:<br>
                        <select id="cmbCountries">
							<option value=0>---select---</option>
                        </select><br>

                        City:<br>
                        <select name="" id="cmbCities" >
                        </select><br>
						Is Admin?<input type="checkbox" id="chk" name="chkBox"><br>
                       <button  id="save" >save</button>
                        <input type=submit id="clear" value="clear">
						
                    </form>
                </div>
            </div>
			
            <div class="item2" >
			<br><br>
                <div id="table">
				</div>

            </div>


    </body>
</html>

<?php
	}}
?>






