<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";
if(isset($_GET['chk'])){
	if($_GET['chk']==1){
		mysql_query("update site_config set config_sitename='".$_POST['txt_name']."',config_sitetitle='".$_POST['txt_title']."',config_metakey='".$_POST['txt_keyword']."',config_metades='".$_POST['txt_description']."',config_upload_limit=".$_POST['txt_upload']." where config_id=".$_POST['txt_id']) or die(mysql_error());
		$strMSG = "Site Configuration Updated Successfully";
	}
	elseif($_GET['chk']==2){
		if($_GET['sid']==1){
			$st=0;
		}
		else{
			$st=1;
		}
		mysql_query("update site_config set status_id=".$st." where config_id=".$_GET['cid']) or die(mysql_error());
		$strMSG = "Status Updated Successfully";
	}
}	 
ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr>
		<td colspan="2" width="100%" class="Header"><?php include("header.php");?></td>
	</tr>
	<tr>
		<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
		<td width="100%" valign="top" class="mainBody"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td class="adminMainHead">Site Configuration</td></tr>
				<tr>
					<td>
			<?php
				if(isset($_GET['op'])){
					if($_GET['op']==1){
						$rss=mysql_query("select * from site_config where config_id=1") or die(mysql_error());
						$rows=mysql_fetch_array($rss);
			?>
						<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" class="FormTables">
							<form name="form1" method="post" action="site_config.php?chk=1" onSubmit="return checkRequired(this);">
								<tr><td colspan="2" align="center" class="TableHeads">Site Configuration</td></tr>
								<tr><td colspan="2" height="12"></td></tr>
								<tr>
									<td width="160" align="right">Site Name:</td>
									<td width="340"><input type="text" name="txt_name" value="<?php print $rows['config_sitename']?>" style="width:300px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
										<input type="hidden" name="txt_id" value="<?php print $_GET['sid']?>"></td>
								</tr>
								<tr>
									<td align="right">Title:</td>
									<td><input type="text" name="txt_title" value="<?php print $rows['config_sitetitle']?>" style="width:300px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
								</tr>
								<tr>
									<td align="right" valign="top" style="padding-top:4px;">Meta Keyword:</td>
									<td><textarea style="width:300px; height:100px;" name="txt_keyword" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"><?php print $rows['config_metakey']?></textarea></td>
								</tr>
								<tr>
									<td align="right" valign="top" style="padding-top:4px;">Meta Description:</td>
									<td><textarea style="width:300px; height:100px;" name="txt_description" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"><?php print $rows['config_metades']?></textarea></td>
								</tr>
								<tr><td colspan="2" height="8"></td></tr>
								<tr>
									<td>&nbsp;</td>
									<td>
										<input type="hidden" name="txt_upload" value="<?php print $rows['config_upload_limit']?>" >
										<input name="Submit" type="submit" class="inputButton" value="SAVE">
										<input name="Submit2" type="button" class="inputButton" value="BACK" onClick="javascript: window.location = '<?php print($_SERVER['HTTP_REFERER']);?>';">
									</td>
								</tr>
								<tr><td colspan="2" height="12"></td></tr>
							</form>
						</table>
			<?php
					}
				}
				else{
			?>
						<table align="center" width="96%" border="0" cellpadding="0" cellspacing="0">
							<tr><td align="center" class="msg"><?php print($strMSG);?></td></tr>
							<tr>
								<td>
									<table width="100%" cellpadding="0" cellspacing="1" border="0" class="ListTables">
										<tr>
											<td align="center" class="TableHeads">Site Name</td>
											<td align="center" class="TableHeads">Title</td>
											<td align="center" class="TableHeads" width="100">Status</td>
											<td align="center" class="TableHeads" width="100">Edit</td>
										</tr>
										<?php
							$rs=mysql_query("select site_config.config_sitename,site_config.config_sitetitle,site_config.config_id,status.status_id,status.status_name from site_config,status where site_config.status_id=status.status_id") or die(mysql_error());
							if(mysql_num_rows($rs)>0)
							{
								while($row=mysql_fetch_array($rs))
								{	
							?>
										<tr class="ListRow1">
											<td><?php print $row['config_sitename']?></td>
											<td><?php print $row['config_sitetitle']?></td>
											<td align="center"><a href="site_config.php?chk=2&cid=<?php print $row['config_id'] ?>&sid=<?php print $row['status_id']?>"><?php print $row['status_name']?></a></td>
											<td align="center"><a href="site_config.php?op=1&sid=<?php print $row['config_id']?>">Edit</a></td>
										</tr>
										<?php
								}
							}
							else
							{	
							?>
										<tr>
											<td colspan="4" align="center" class="ListRow1">No Record Found</td>
										</tr>
										<?php
							}
							?>
									</table>
								</td>
							</tr>
						</table>
						<?php
			}
			?>
						<br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
