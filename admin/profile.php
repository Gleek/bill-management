<?php

session_start();

include "../config.php";

if(isset($_POST['check_pass'])){
  $pass=stripslashes(mysql_real_escape_string($_POST['check_pass']));
  $result=mysql_query("select * from admin where username='".$_SESSION['user']."' and pass='".$pass."'");
  $count=mysql_num_rows($result);
  if($count==1){
    echo "yes";
  }else
    echo "no";
    exit();

}

?>
<script type="text/javascript">

function c_pass () {

  var pas=$("#check_pass").val();
  $.post("admin/profile.php",
    {
      check_pass : pas
    },
    function(result){
      if(result=="yes"){
        $("#check_p").hide();
        $("#form_p").show();
      }else
        alert("Wrong Password");
      }
    );

  
}


</script>


<div id="check_p">
    <label for="check_pass">Enter password to access profile</label>
    <input type="password" class="form-control" id="check_pass" size="40" >
    <button class="btn btn-default" onclick="c_pass();">Submit</button>
</div>



<?php


if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$x=array_keys($_POST);

	if ($x[0]=="address") {
		exit();
	}
	
	$result=mysql_query("update admin set ".$x[0]." = '".$_POST[$x[0]]."' where username='".$_SESSION['user']."'");
	exit();
}

$result=mysql_query("select * from admin where username='".$_SESSION['user']."'");
$row=mysql_fetch_array($result);

?>

<script type="text/javascript">

function send_data(attr){

	var data = {};
	var value=$("#"+attr).val();
	data[attr]=value;
	
	

  	$.post("admin/profile.php",data,
		function(result){
			$("#"+attr+"_pic").show();
			setTimeout(function(){$("#"+attr+"_pic").hide()},3000);

  		}
  	);
}

var change=0;
function change_type () {
  if(change==0){ 
    $("#pass").attr("type","text");
    change=1;
  }else{
    $("#pass").attr("type","password");
    change=0;
  }

}


</script>

<div id="form_p" style="display:none;">
<form role="form">  
  <div class="form-group">
    <label for="email">Email address</label>
    <img src="images/green_tick.png" id="email_pic" style="display:none;">
    <input type="email" onkeyup="send_data('email');" class="form-control mytext" id="email" size="40" value="<?php echo $row['email']; ?>" >
  	
  </div>
  
  <div class="form-group">
    <label for="pass">Password</label>
    <img src="images/green_tick.png" id="pass_pic" style="display:none;">
    <input type="password" onkeyup="send_data('pass');" class="form-control mytext" id="pass" value="<?php echo $row['pass']; ?>">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox" onchange="change_type();"> Check to view password
    </label>
  </div>

</form>
</div>
