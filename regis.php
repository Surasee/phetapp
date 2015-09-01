<?
include("connect.php");
session_start();
if(isset($_SESSION[ses_username]))
	{ ?>	
<? echo "<script type='text/javascript'>alert('Already Login');</script>";
?>
<meta http-equiv="refresh" content="1;URL= main.php" />
<? 
	}
else{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REGISTER</title>
<script type="text/javascript" src="jquery-1.11.2.js" ></script>
<script type="text/javascript">
//รอ เขียนโค้ดใส่ สคลิป
$(document).ready(function() {
	var n = 0; //username
	var p = 0; //password
	var e = 0; //email
 	$("#u_name").change(function(){
		$("#uname").empty();
		var name = $("#u_name").val();		
		var url = "functions_lib.php?tag=checkname&u_name="+name;
		$.get(url, function(data)
		{
			if(data==1)
			{
				$("#uname").html(" <font color='red'>ชื่อผู้ใช้นี้ได้ถูกใช้งานไปแล้ว</font>");
				n = 0;
			}
			else
			{
				$("#uname").html(" <font color='blue'>ใช้งานได้</font>");
				n = 1;
			}
		});
	});//
	$("#u_mail").change(function(){
		$("#umail").empty();
		var email = $("#u_mail").val();
		var c_mail =/^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z0-9]{2,5})$/
		if(email.match(c_mail))
		{
		var url = "functions_lib.php?tag=checkmail&u_mail="+email;
		$.get(url, function(data)
		{
			if(data==1)
			{
				$("#umail").html(" <font color='red'>อีเมล์นี้ได้ถูกใช้งานไปแล้ว</font>");
				e = 0;
			}
			else
			{
				$("#umail").html(" <font color='blue'>ใช้งานได้</font>");
				e = 1;
			}
		});
		}
		else
		{
			$("#umail").html(" <font color='red'>รูปแบบอีเมล์ไม่ถูกต้อง</font>");	
		}
	});//
	
	$("#u_pass2,#u_pass").change(function(){
		$("#upass").empty();
		var pass = $("#u_pass").val();
		var pass2 = $("#u_pass2").val();
		if(pass != pass2)
		{
			$("#upass").html(" <font color='red'>รหัสผ่านไม่ตรงกัน</font>");
				p = 0;
		}
		else
		{
			$("#upass").html(" <font color='blue'>ใช้งานได้</font>");
				p = 1;
		}
	});
	
	$("#button").click(function(){
		if(confirm('Confirm to submit')==true)
	{
		if(p == 1 && e == 1 && n == 1)
		{
			alert("ข้อมูลถูกต้อง");
			return true;
		}
		else
		{
			alert("ข้อมูลผิดพลาด");
			return false;
		}
	}
		else
	{
		return false;
	}
	});
	
});//READY FUNCTION
function showPreview(ele)
{
$("img").attr('src',ele.value);
if(ele.files && ele.files[0])
	{
		var reader = new FileReader();
		reader.onload = function (e){
			$("img").attr('src',e.target.result);
		}
		reader.readAsDataURL(ele.files[0]);
	}
}
</script>
<?
	if(isset($u_name,$u_pass,$u_add,$u_mail,$u_fname,$u_pic)){
		/*
	echo "<script type='text/javascript'>alert('isset yes  $u_name $u_pass $u_mail $u_add $u_fname $u_pic');</script>";
		*/
	$folder = rand(); //สร้างโฟเดอร์ ที่มีการแรนดอมขึี้มา 
	mkdir("pic/".$folder,0777); // every can read write exe. ,mkdir Make Dirctory
	//ประกาศตัวแปรเก็บค่าไฟล์ ที่ อัพโหลดมาโดยใช้ชื่อ ไฟล์ ตามที่ได้ upload มา
	$u_pic = "pic/".$folder."/".$_FILES["u_pic"]["name"];
	//เก็บการ อัพโหลดไฟล์ แต่เปลี่ยนเป็นชื่อใหม่เพื่อไม่ให้มีไฟล์ช้ำกัน
	move_uploaded_file($_FILES["u_pic"]["tmp_name"],$u_pic);
	
	
	
	$sql = "insert into member values(NULL,'$u_name','$u_pass','$u_fname','$u_mail','$u_add','$u_pic')";
	$result = mysql_query($sql); // mysql_query(คำสั่งภาษา SQL )ฟังห์ชั่นส่งคำสั่ง sql ไปที่ฐานข้อมูล
	if($result)
		{
		$message = "ใส่ข้อมูลลง database เรียบร้อย";
		echo "<script type='text/javascript'>alert('$message');</script>";	
		?>
			<meta http-equiv="refresh" content="1;URL=index.php" />	
		<?
		}
	else{
		$message = mysql_error();
		echo "<script type='text/javascript'>alert('$message');</script>";
		} //mysql_errorฟังก์ชั่นในการแสดงข้อผิดพลาด
		unset($u_name,$u_pass,$u_add,$u_mail,$u_fname,$u_pic);
}
else{
	/*
	echo "<script type='text/javascript'>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง!!');</script>";
	*/
	}
?>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
  <table width="800" border="1" align="center">
    <tr>
      <td colspan="4" align="center">สมัครสมาชิก</td>
    </tr>
    <tr>
      <td width="111">USERNAME</td>
      <td width="270"><input name="u_name" type="text" id="u_name" size="30" maxlength="30" /></td>
      <td width="397" colspan="2"><span id="uname"></span></td>
    </tr>
    <tr>
      <td>PASSWORD</td>
      <td><input name="u_pass" type="password" id="u_pass" size="30" maxlength="30" /></td>
      <td width="397" colspan="2"><span id="upass"></span></td>
    </tr>
    <tr>
      <td>RE_PASS</td>
      <td><input name="u_pass2" type="password" id="u_pass2" size="30" maxlength="30" /></td>
      <td width="397" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>NAME</td>
      <td><input name="u_fname" type="text" id="u_fname" size="30" maxlength="255" /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>ADDRESS</td>
      <td><input name="u_add" type="text" id="u_add" size="30" maxlength="255" /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>E-MAIL</td>
      <td><input name="u_mail" type="text" id="u_mail" size="30" maxlength="255" /></td>
      <td colspan="2"><span id="umail"></span></td>
    </tr>
    <tr>
      <td>PICTURE</td>
      <td><input name="u_pic" type="file" id="u_pic" size="30" maxlength="255" onChange="showPreview(this)" /></td>
      <td colspan="2"><span id="upic"></span></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="Submit" id="button" value="SUBMIT" />
      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="button2" id="button2" value="CLEAR" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <center>

  <img width="720" height="640" id="imgx"/>
 
  </center>
</form>
</body>
</html>
<? } ?>