<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 
$act=$_POST["act"];
if ($act == "userTable") {
   echo'<table>';
echo'<tr>';
    echo'<th>UserId</th>';
    echo'<th>Login</th> ';
    echo'<th>Password</th>';
	echo'<th>Name</th>';
    echo'<th>Email</th> ';
    echo'<th>Country</th>';
	 echo'<th>City</th>';
	echo'<th>CreatedBy</th>';
    echo'<th>CreatedOn</th> ';
    echo'<th>IsAdmin</th>';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM USERS";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["userid"].'</td>';
					echo'<td>'.$row["login"].'</td>';
					echo'<td>'.$row["password"].'</td>';
					echo'<td>'.$row["name"].'</td>';
					echo'<td>'.$row["email"].'</td>';
					$ctry=$row['countryid'];
					$q="Select * from country where id=$ctry";
					$country = mysqli_query($conn, $q);
					$d = mysqli_fetch_assoc($country);
					echo "<td>".$d['name']."</td>";
					
					$ct=$row['cityid'];
					$sq="Select * from city where id=$ct";
					$city = mysqli_query($conn, $sq);
					$rs = mysqli_fetch_assoc($city);
					echo "<td>".$rs['name']."</td>";
					
					echo'<td>'.$row["createdby"].'</td>';
					echo'<td>'.$row["createdon"].'</td>';
					
					if($row["isadmin"]==1)
					{
						echo'<td>Yes</td>';
					}
					else
						echo'<td>No</td>';
						$id=$row["userid"];
					echo"<td><button value='1' class='edit' onclick='editUser($id);'> edit </button></td>";
					echo"<td><button value='2' class='delete' onclick='deleteUser($id);'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';
}

if ($act == "getCountries") {
    $sql = "SELECT id,name FROM COUNTRY";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["id"]==$_POST["ed"]){
            $id = $row["id"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";}
        }
    }
	$sql = "SELECT id,name FROM COUNTRY";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["id"]!=$_POST["ed"]){
            $id = $row["id"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";}
        }
    }
}

if ($act == "getCities") {
	$cntryId=$_REQUEST["countryId"];
    $sql = "SELECT * FROM City";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["countryid"]==$cntryId && $_POST["edCity"]==$row["id"]){
            $id = $row["id"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
	$sql = "SELECT * FROM City";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["countryid"]==$cntryId && $_POST["edCity"]!=$row["id"]){
            $id = $row["id"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
}

if($act=="getUserId"){
	
	$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$_SESSION["user"])
					 {
						 $u=$row["userid"];	
						 echo($u);
					 }
				}	
			}	
}
if ($act == "saveUser") {
	$flags=true;
	if($_POST["flag"]==0){
	$c=0;
	if(isset($_POST["isAdmin"]) == true)
		{
			$c=1;
		}
		$u=0;
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$_SESSION["user"])
					 {
						 $u=$row["userid"];	
					 }
					 if($row["login"]==$_POST["login"] || $_POST["pswd"]==$row["password"]){
						 $flags=false;
					 }
				}	
			}	
			if($flags==true){
		$l=$_POST["login"];
		$p=$_POST["pswd"];
		$n=$_POST["name"];
		$e=$_POST["email"];
		$cn=$_POST["countryId"];
		$ci=$_POST["cityId"];
		
		$d=date("Y-m-d h:i:s");
		$sql = "INSERT INTO USERS (login, password, name, email, countryid,cityid, createdby, createdon, isadmin)
		VALUES ('$l','$p','$n','$e','$cn','$ci','$u','$d','$c')";
	if ($conn->query($sql) === TRUE) {
    echo "new record has been added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
if($flags==false){
	echo"login or email already exist";
}
	}
	}
//	
	if($_POST["flag"]==1){
		
			
			$cv=0;
			if(isset($_POST["isAdmin"]) == true)
		{
			$cv=1;
		}
		
		$l=$_POST["login"];
		$p=$_POST["pswd"];
		$n=$_POST["name"];
		$e=$_POST["email"];
		$cn=$_POST["countryId"];
		$ci=$_POST["cityId"];
		$usid=$_POST["uid"];
		$sql="UPDATE users SET login='$l', password='$p', name='$n', email='$e', countryid='$cn',cityid='$ci',isadmin='$cv' WHERE userid=$usid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}
	
}
if($act=="editUser"){
	$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["userid"]==$_POST["userId"])
					 {
						 $obj=array($row["countryid"],$row["cityid"],$row["name"],$row["login"],$row["password"],$row["email"],$row["isadmin"]);
						echo implode('~',$obj);
					 }
				}	
			}
	
}

/*if($act=="edSave"){
			$usid=$_POST["userid"];
			
			$c=0;
			if(isset($_POST["isAdmin"]) == true)
		{
			$c=1;
		}
		
		$l=$_POST["login"];
		$p=$_POST["pswd"];
		$n=$_POST["name"];
		$e=$_POST["email"];
		$cn=$_POST["countryId"];
		$ci=$_POST["cityId"];
		$sql="UPDATE users SET login='$l', password='$p', name='$n', email='$e', countryid='$cn',cityid='$ci',isadmin='$c' WHERE userid=$usid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}*/

		if($act=="delUser"){
			$d=$_POST["did"];
			$sql = "DELETE FROM users WHERE userid=$d";

if ($conn->query($sql) === TRUE) {
     echo "Record deleted successfull";
} else {
    echo "Error deleting record:" . $conn->error;
}
		}
		
		if($act=="roleTable"){
			echo'<table>';
echo'<tr>';
    echo'<th>RoleId</th>';
	echo'<th>Name</th>';
    echo'<th>Desription</th> ';
	echo'<th>CreatedBy</th>';
    echo'<th>CreatedOn</th> ';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM roles";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["roleid"].'</td>';
					echo'<td>'.$row["name"].'</td>';
					echo'<td>'.$row["description"].'</td>';
					echo'<td>'.$row["createdby"].'</td>';
					echo'<td>'.$row["createdon"].'</td>';
					$id=$row["roleid"];
					echo"<td><button type='submit' value='$id' name='edit' onclick='editRole($id);'> edit </button></td>";
					echo"<td><button type='submit' value='$id' name='delete' onclick='deleteRole($id);'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';
		}
		
		if ($act == "saveRole") {
	if($_POST["flag"]==1){
		
		
		$r=$_POST["role"];
		$des=$_POST["desc"];
		
		$rid=$_POST["rid"];
		$sql="UPDATE roles SET name='$r', description='$des' WHERE roleid=$rid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}
	
	else if($_POST["flag"]==0){
		$u=0;
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$_SESSION["user"])
					 {
						 $u=$row["userid"];	
					 }
					 }
				}	
				
			
		$r=$_POST["role"];
		$des=$_POST["desc"];
		
		$d=date("Y-m-d h:i:s");
		$sql = "INSERT INTO roles (name, description, createdby, createdon)
		VALUES ('$r','$des','$u','$d')";
	if ($conn->query($sql) === TRUE) {
    echo "new record has been added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}
	
//	
	
	
}

if($act=="delRole"){
			$d=$_POST["roleid"];
			$sql = "DELETE FROM roles WHERE roleid=$d";

if ($conn->query($sql) === TRUE) {
     echo "Record deleted successfull";
} else {
    echo "Error deleting record:" . $conn->error;
}
		}
		
		if($act=="editRole"){
	$sql = "SELECT * FROM roles";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["roleid"]==$_POST["roleId"])
					 {
						 $obj=array($row["name"],$row["description"]);
						echo implode('~',$obj);
					 }
				}	
			}
	
}




if($act=="permTable"){
			echo'<table>';
echo'<tr>';
    echo'<th>PermissionId</th>';
	echo'<th>Name</th>';
    echo'<th>Desription</th> ';
	echo'<th>CreatedBy</th>';
    echo'<th>CreatedOn</th> ';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["permissionid"].'</td>';
					echo'<td>'.$row["name"].'</td>';
					echo'<td>'.$row["description"].'</td>';
					echo'<td>'.$row["createdby"].'</td>';
					echo'<td>'.$row["createdon"].'</td>';
					$id=$row["permissionid"];
					echo"<td><button type='submit' value='$id' name='edit' onclick='editPerm($id);'> edit </button></td>";
					echo"<td><button type='submit' value='$id' name='delete' onclick='deletePerm($id);'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';
		}
		
		if ($act == "saveperm") {
	if($_POST["flag"]==1){
		
		
		$p=$_POST["perm"];
		$des=$_POST["desc"];
		
		$pid=$_POST["pid"];
		$sql="UPDATE permission SET name='$p', description='$des' WHERE permissionid=$pid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}
	
	else if($_POST["flag"]==0){
		$u=0;
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$_SESSION["user"])
					 {
						 $u=$row["userid"];	
					 }
					 }
				}	
					
		$p=$_POST["perm"];
		$des=$_POST["desc"];
		
		$d=date("Y-m-d h:i:s");
		$sql = "INSERT INTO permission (name, description, createdby, createdon)
		VALUES ('$p','$des','$u','$d')";
	if ($conn->query($sql) === TRUE) {
    echo "new record has been added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}
	
//	
	
	
}

if($act=="delPerm"){
			$d=$_POST["permid"];
			$sql = "DELETE FROM permission WHERE permissionid=$d";

if ($conn->query($sql) === TRUE) {
     echo "Record deleted successfull";
} else {
    echo "Error deleting record:" . $conn->error;
}
		}
		
if($act=="editPerm"){
	$sql = "SELECT * FROM permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["permissionid"]==$_POST["permId"])
					 {
						 $obj=array($row["name"],$row["description"]);
						echo implode('~',$obj);
					 }
				}	
			}
	
}
if($act=="rolePermTable"){
	
	echo'<table>';
echo'<tr>';
    echo'<th>Role Permission Id</th>';
	echo'<th>Role</th>';
	echo'<th>Permission</th>';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM role_permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["id"].'</td>';
					$rid=$row["roleid"];
					$s = "SELECT * FROM roles where roleid=$rid";
					$rslt = mysqli_query($conn, $s);
					$records = mysqli_num_rows($rslt);					
					if ($records > 0){
					while($data = mysqli_fetch_assoc($rslt)){
					echo'<td>'.$data["name"].'</td>';
					}
					}
					$pid=$row["permissionid"];
					$sq = "SELECT * FROM permission where permissionid=$pid";
					$rs = mysqli_query($conn, $sq);
					$recordsF = mysqli_num_rows($rs);					
					if ($recordsF > 0){
					while($perm = mysqli_fetch_assoc($rs)){
					echo'<td>'.$perm["name"].'</td>';
					}
					}
					$id=$row["id"];
					echo"<td><button type='submit' value='$id' name='edit' onclick='editRolePerm($id);'> edit </button></td>";
					echo"<td><button type='submit' value='$id' name='delete' onclick='delRolePerm($id);'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';

}
if ($act == "getRoles") {
	if($_POST["ed"]!=0){
    $sql = "SELECT roleid,name FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["roleid"]==$_POST["ed"]){
            $id = $row["roleid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }}
	$sql = "SELECT roleid,name FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["roleid"]!=$_POST["ed"]){
            $id = $row["roleid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
}

if ($act == "getPerm") {
	if($_POST["edp"]!=0){
    $sql = "SELECT permissionid,name FROM permission";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["permissionid"]==$_POST["edp"]){
            $id = $row["permissionid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }}
	$sql = "SELECT permissionid,name FROM permission";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["permissionid"]!=$_POST["edp"]){
            $id = $row["permissionid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
}

if ($act == "saveRolePerm") {
	if($_POST["flag"]==0){
		
		$cr=$_POST["roleId"];
		$cp=$_POST["permId"];
		
		$d=date("Y-m-d h:i:s");
		$sql = "INSERT INTO role_permission (roleid,permissionid)
		VALUES ('$cr','$cp')";
	if ($conn->query($sql) === TRUE) {
    echo "new record has been added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
		}	
		
//	
	if($_POST["flag"]==1){	
		$rpid=$_POST["rpid"];
		$cr=$_POST["roleId"];
		$cp=$_POST["permId"];
		$sql="UPDATE role_permission SET roleid='$cr', permissionid='$cp' WHERE id=$rpid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}
	
}

if($act=="delRolePerm"){
	
	$d=$_POST["rpid"];
			$sql = "DELETE FROM role_permission WHERE id=$d";

if ($conn->query($sql) === TRUE) {
     echo "Record deleted successfull";
} else {
    echo "Error deleting record:" . $conn->error;
}
}

if($act=="editRolePerm"){
	$sql = "SELECT * FROM role_permission";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["id"]==$_POST["rpid"])
					 {
						 $obj=array($row["roleid"],$row["permissionid"]);
						echo implode('~',$obj);
					 }
				}	
			}
	
}

if($act=="userRoleTable"){
	
	echo'<table>';
echo'<tr>';
    echo'<th>UserRoleId</th>';
	echo'<th>Role</th>';
	echo'<th>User</th>';
	echo'<th>Edit</th> ';
    echo'<th>Delete</th>';
  echo'</tr>';
  $sql = "SELECT * FROM user_role";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["id"].'</td>';
					$rid=$row["roleid"];
					$s = "SELECT * FROM roles where roleid=$rid";
					$rslt = mysqli_query($conn, $s);
					$records = mysqli_num_rows($rslt);					
					if ($records > 0){
					while($data = mysqli_fetch_assoc($rslt)){
					echo'<td>'.$data["name"].'</td>';
					}
					}
					$uid=$row["userid"];
					$sq = "SELECT * FROM users where userid=$uid";
					$rs = mysqli_query($conn, $sq);
					$recordsF = mysqli_num_rows($rs);					
					if ($recordsF > 0){
					while($user = mysqli_fetch_assoc($rs)){
					echo'<td>'.$user["name"].'</td>';
					}
					}
					$id=$row["id"];
					echo"<td><button type='submit' value='$id' name='edit' onclick='editRoleUser($id);'> edit </button></td>";
					echo"<td><button type='submit' value='$id' name='delete' onclick='delRoleUser($id);'> delete </button></td>";
					echo'</tr>';
					
				}
			}
echo'</table>';

}
if ($act == "getRoles") {
	if($_POST["ed"]!=0){
    $sql = "SELECT roleid,name FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["roleid"]==$_POST["ed"]){
            $id = $row["roleid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }}
	$sql = "SELECT roleid,name FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["roleid"]!=$_POST["ed"]){
            $id = $row["roleid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
}

if ($act == "getUser") {
	if($_POST["edu"]!=0){
    $sql = "SELECT userid,name FROM users";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["userid"]==$_POST["edu"]){
            $id = $row["userid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }}
	$sql = "SELECT userid,name FROM users";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
			if($row["userid"]!=$_POST["edu"]){
            $id = $row["userid"];
            $name = $row["name"];
            echo "<option value='$id'>$name</option>";
			}
        }
    }
	
}

if ($act == "saveRoleUser") {
	if($_POST["flag"]==0){
		
		$cr=$_POST["roleId"];
		$cu=$_POST["userId"];
		
		$d=date("Y-m-d h:i:s");
		$sql = "INSERT INTO user_role (roleid,userid)
		VALUES ('$cr','$cu')";
	if ($conn->query($sql) === TRUE) {
    echo "new record has been added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
		}	
		
//	
	if($_POST["flag"]==1){	
		$ruid=$_POST["ruid"];
		$cr=$_POST["roleId"];
		$cp=$_POST["userId"];
		$sql="UPDATE user_role SET roleid='$cr', userid='$cp' WHERE id=$ruid";
		if ($conn->query($sql) === TRUE) {
    echo 'record has been edited';
} 	
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		}
	
}

if($act=="delRoleUser"){
	
	$d=$_POST["ruid"];
			$sql = "DELETE FROM user_role WHERE id=$d";

if ($conn->query($sql) === TRUE) {
     echo "Record deleted successfull";
} else {
    echo "Error deleting record:" . $conn->error;
}
}

if($act=="editRoleUser"){
	$sql = "SELECT * FROM user_role";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["id"]==$_POST["ruid"])
					 {
						 $obj=array($row["roleid"],$row["userid"]);
						echo implode('~',$obj);
					 }
				}	
			}
	
}
if($act=="loginHistory"){
	
	echo'<table>';
echo'<tr>';
    echo'<th>UserId</th>';
    echo'<th>Login</th> ';
    echo'<th>Login Time</th>';
	echo'<th>Machine IP</th>';
  echo'</tr>';
  $sql = "SELECT * FROM loginhistory";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){
				while($row = mysqli_fetch_assoc($result)) {					
					echo'<tr>';
					echo'<td>'.$row["userid"].'</td>';
					echo'<td>'.$row["login"].'</td>';
					echo'<td>'.$row["logintime"].'</td>';
					echo'<td>'.$row["machineip"].'</td>';
					echo'</tr>';
					
				}
			}
echo'</table>';
}
?>