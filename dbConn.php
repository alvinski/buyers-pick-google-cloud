<?php
$host = ":/cloudsql/skibuyerspick:buyerspick";
$username = "root";
$password = "";
$dbname = "skibuyerspick:buyerspick";

$conn = mysql_connect($host, $username, $password);
$dbselect = mysql_select_db("buyerspick", $conn) or die(mysql_error());
if(!$dbselect)
{
	die("Could not select Database : ". mysql_error());
}
if(!$conn)
{
	die("Could not connect to MySql Google Server : ". mysql_error());
}
//echo "Connected to MySql Google Server<br>";
//mysql_close($conn);

$sql = mysql_query("select * from ba_tbl_user;") or die(mysql_error());
$numRows = mysql_num_rows($sql);
//echo "Num Rows : ".$numRows;
?>

<table cellpadding="10" cellspacing="10">
<th>Email</th>
<th>Name</th>
<th>Device</th>
<th>Last login</th>
<th>Active Status</th>
<th>Created Date</th>
<th>Verification Key</th>
<th>Activated Date</th>
<th>Old Password</th>
<th>Last Modified</th>
<th>Created By</th>
<th>Subscription Type</th>
<th>User type</th>
<?
while($row = mysql_fetch_assoc($sql))
{
	?>
    <tr>
    <td><?=$row['email']?></td>
    <td><?=$row['name']?></td>
    <td><?=$row['device']?></td>
    <td><?=$row['last_login']?></td>
    <td><?=$row['active']?></td>
    <td><?=$row['created_date']?></td>
    <td><?=$row['verification)key']?></td>
    <td><?=$row['active_date']?></td>
    <td><?=$row['old_password']?></td>
    <td><?=$row['last_modified']?></td>
    <td><?=$row['created_by']?></td>
    <td><?=$row['subscribtion_type']?></td>
    <td><?=$row['user_type']?></td>
    </tr>
    <?
}
?>
</table>
<?

?>
