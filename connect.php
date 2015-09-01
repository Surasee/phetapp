<?
$connect = mysql_connect("127.0.0.1","root","admin"); //1 mysql_connect() ฟังก์ชั่นในการเชื่อมต่อกับฐานข้อมูล
mysql_select_db("appphetdb");//2 ฟังก์ชั่นในการเลือกฐานข้อมูลที่ต้องการใช้งาน
mysql_query('SET NAMES utf8');
?>