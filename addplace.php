<?
include("connect.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADD PLACE</title>

<script type="text/javascript" src="jquery-1.11.2.js" ></script>
<script type="text/javascript">
//รอ เขียนโค้ดใส่ สคลิป
$(document).ready(function() {
	var n = 0; //place_check
	var l1 = 0; // place_lat
	var l2 = 0; // place_long
	var ty = 0;// place_type
	$("#place_lat").change(function(){
		$("#lat").empty();
		var check_lat = $("#place_lat").val();
		var check =/^(\d{1,3})[.](\d{1,6})$/
		if(check_lat.match(check))
		{
			$("#lat").html(" <font color='green'>รูปแบบถูกต้อง</font>");
			l1 = 1;
		}
		else
		{
			
			$("#lat").html(" <font color='red'>รูปแบบผิดพลาด ตัวอย่างที่ถูก 111.123456 หรือ 11.123456 </font>");
			l1 = 0;	
		}
	});// lat
	$("#place_long").change(function(){
		$("#long").empty();
		var check_long = $("#place_long").val();
		var check =/^(\d{1,3})[.](\d{1,6})$/
		if(check_long.match(check))
		{
			$("#long").html(" <font color='green'>รูปแบบถูกต้อง</font>");
			l2 = 1;
		}
		else
		{
			
			$("#long").html(" <font color='red'>รูปแบบผิดพลาด ตัวอย่างที่ถูก 111.123456 หรือ 11.123456 </font>");
			l2 = 0;	
		}
	});// long
	$("#place_type").change(function(){
		$("#type").empty();
		var check_type = $("#place_type").val();
		var check = "no";
		if(check_type != check)
		{
			$("#type").html(" <font color='green'></font>");
			ty = 1;
		}
		else
		{
			
			$("#type").html(" <font color='red'>กรุณาเลือก ประเภทของสถานที่</font>");
			ty = 0;	
		}
		
		
		
		});// type
	
	
	
	
	
	$("#button").mouseover(function(){
		$("#pname").empty();
		var name = $("#place_name").val();
		var lat = $("#place_lat").val();
		var long = $("#place_long").val();
		var url = "index.php?tag=place_check&place_name="+name+"&place_lat="+lat+"&place_long="+long;
		$.get(url, function(data)
		{
			
			if(data==1)
			{
				$("#pname").html(" <font color='red'>สถานที่นี้เคยถูกบันทึกแล้ว</font>");
				n = 0;
			}
			else
			{
				$("#pname").html(" <font color='blue'>สามารถบันทึกได้</font>");
				
				if(name == "")
				{
					$("#pname").html(" <font color='red'>กรุณาระบุชื่อสถานที่</font>");
					n = 0;	
				}
				else
				{
					n = 1;
				}
			}
		}); //get url		
	}); // check 



			
	$("#button").click(function(){
		
		if(confirm('Confirm to submit')==true)
	{
				
		if(n == 1 && l1 == 1 && l2 == 1 && ty == 1)
		{
			alert("ข้อมูลถูกต้อง");
			return true;
		}
		else
		{
		
			alert("ข้อมูลผิดพลาด");
			//alert("n = "+n+" l1 = "+l1+" l2 = "+l2+" ty = "+ty);
			return false;
		}
	}// if true
		else
	{
		return false;
	}
	});
	
});//READY FUNCTION

</script>
<?
	if(isset($place_name,$place_lat,$place_long,$place_type)){	
	$sql = "insert into place_list values(NULL,'$place_name','$place_lat','$place_long','$place_type')";
	$result = mysql_query($sql); // mysql_query(คำสั่งภาษา SQL )ฟังห์ชั่นส่งคำสั่ง sql ไปที่ฐานข้อมูล
	if($result)
		{
		$message = "ใส่ข้อมูลลง database เรียบร้อย";
		echo "<script type='text/javascript'>alert('$message');</script>";	
		?>
			<meta http-equiv="refresh" content="1;URL=addplace.php" />	
		<?
		}
	else{
		$message = mysql_error();
		echo "<script type='text/javascript'>alert('$message');</script>";
		} //mysql_errorฟังก์ชั่นในการแสดงข้อผิดพลาด
		unset($place_name,$place_lat,$place_long,$place_type);
}
else{
	/*
	echo "<script type='text/javascript'>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง!!');</script>";
	*/
	pageA();
	
	
	
	
	
	
	}
?>
</head>
<?
function pageA(){
?>
<body>
<p>&nbsp;</p>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
  <table width="800" border="1" align="center">
    <tr>
      <td colspan="4" align="center">เพิ่มสถานที่</td>
    </tr>
    <tr>
      <td width="145">PLACE NAME</td>
      <td width="236"><input name="place_name" type="text" id="place_name" size="30" maxlength="255" /></td>
      <td width="397" colspan="2"><span id="pname"></span></td>
    </tr>
    <tr>
      <td>LAT</td>
      <td><input name="place_lat" type="text" id="place_lat" size="30" maxlength="12" /></td>
      <td width="397" colspan="2"><span id="lat"></span></td>
    </tr>
    <tr>
      <td>LONG</td>
      <td><input name="place_long" type="text" id="place_long" size="30" maxlength="12" /></td>
      <td width="397" colspan="2"><span id="long"></span></td>
    </tr>
    <tr>
      <td>MAIN TYPE</td>
      <td>
        <select name="place_type" id="place_type">
          <option value="no" selected="selected">กรุณาเลือกรายการ</option>
         
        <?
			
			$sql = "select * from place_type ORDER BY id_type ASC";// ASC น้อยไปมาก DSC มากไปน้อย
			$result = mysql_query($sql);
			while ($row=mysql_fetch_array($result))//ดึงข้อมูลออกมาจาก Array ทีละ record 
			{
				
		?>
        <option value="<? echo $row["id_type"] ?>" ><? echo $row["name_type"] ?></option>
        <? } ?>
        
        
      </select></td>
      <td colspan="2"><span id="type"><font color='red'>กรุณาเลือก ประเภทของสถานที่</font></span></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="Submit" id="button" value="SUBMIT" />
      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="button2" id="button2" value="CLEAR" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <center>
  </center>
</form>

</body>
<?
} // pageA
?>

</html>