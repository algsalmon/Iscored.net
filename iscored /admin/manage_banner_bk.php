<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
/* Instantiate class */
require_once("../lib/class.pager1.php"); 
$p = new Pager1;
$strMSG = "";
$FormHead = "";

if(isset($_REQUEST['btnAdd'])){
	$fileUp = "";
	$ban_id = getMaximum("banners","ban_id");
	$ban_file = "";
	$txtbantitle = "";
	$dirName = "../banner";
	if (!empty($_FILES["ban_file"]["name"])){
		$ban_file = $ban_id . "_" . $_FILES["ban_file"]["name"];
		if(move_uploaded_file($_FILES['ban_file']['tmp_name'], $dirName."/".$ban_file)){
			$fileUp = $ban_file;
		}
	}
	mysql_query("INSERT INTO banners(ban_id, barea_id, ban_name, ban_file, ban_link, ban_startdate, ban_enddate, status_id, btype_id) VALUES(".$ban_id.", ".$_REQUEST['bareaid'].", '".$_REQUEST['txtbantitle']."', '".$fileUp."', '".$_REQUEST['txtlink']."', '".$_REQUEST['txtstartdate']."', '".$_REQUEST['txtenddate']."', 1, '".$_REQUEST['btype']."')") or die(mysql_error());
	header("Location: manage_banner.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){
	$strQuery = "";
	$dirName = "../banner";
	if (!empty($_FILES["ban_file"]["name"])){
		@unlink("../banner/".$_REQUEST['filePath']);
		$ban_file = $_REQUEST['ban_id'] . "_" . $_FILES["ban_file"]["name"];
		if(move_uploaded_file($_FILES['ban_file']['tmp_name'], $dirName."/".$ban_file )){
			$strQuery = ", ban_file='".$ban_file."'";
		}
	}
	mysql_query("UPDATE banners SET ban_name='".$_REQUEST['txtbantitle']."', ban_link='".$_REQUEST['txtlink']."', barea_id=".$_REQUEST['bareaid'].",  ban_startdate = '".$_REQUEST['txtstartdate']."', ban_enddate='".$_REQUEST['txtenddate']."', btype_id='".$_REQUEST['btype']."' ".$strQuery." WHERE ban_id=".$_REQUEST['ban_id']."");
	header("Location: manage_banner.php?op=2");
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Banner";
		$grs = mysql_query("SELECT * FROM banners WHERE ban_id = ".$_REQUEST['ban_id']);
		if(mysql_num_rows($grs) > 0){
			$grow = mysql_fetch_object($grs);
			$txtbantitle = $grow->ban_name;
		//	$txtareaname    = $grow->barea_name;
			$bareaid = $grow->barea_id;
			$filePath = $grow->ban_file;
			$txtlink = $grow->ban_link;
			$txtstartdate = $grow->ban_startdate;
			$txtenddate = $grow->ban_enddate;
			$btype = $grow->btype_id;
		}
	}
	else{
		$FormHead = "Add New ";
		if(!isset($_REQUEST['btnAdd'])){
			$txtbantitle = "";
			$txtlink = "";
			$txtstartdate = "";
			$txtenddate = "";
			$bareaid = 0;
			$txtareaname = "";
			$btype = 0;
		}
	}
}

if(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM banners WHERE ban_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$strMSG = "Record(s) deleted successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}

if(isset($op)){
	switch ($op) {
		case 1:
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$strMSG = "Record Updated Successfully";
			break;
	}
}
ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<script language="JavaScript" src="../lib/calendar1.js"></script>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr>
		<td colspan="2" width="100%" class="Header"><?php include("header.php");?></td>
	</tr>
	<tr>
	
	<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
	<td width="100%" valign="top" class="mainBody"><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="adminMainHead">Banner Management</td>
			</tr>
			<tr>
			
			<td align="center"><div align="center" class="msg" style="width:98%"><?php print($strMSG);?></div>
				<?php
						if(isset($_REQUEST['action'])){
					?>
				<table border="0" align="center" cellpadding="1" cellspacing="1" class="FormTables">
					<form name="form1" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" method="post" enctype="multipart/form-data">
						<tr>
							<td colspan="2" align="left" class="TableHeads"><?php print($FormHead);?></td>
						</tr>
						<tr>
							<td colspan="2" height="10"></td>
						</tr>
						<tr>
							<td align="right">Area:</td>
							<td align="left"><select name="bareaid" class="inputsmallBorder" style="width: 200px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
									<?php FillSelected("banner_areas", "barea_id", "barea_name", $bareaid); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">Banner Type:</td>
							<td align="left"><select name="btype" class="inputsmallBorder" style="width: 200px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
									<?php FillSelected("banner_type", "btype_id", "btype_name", $btype); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="140" align="right">Title:</td>
							<td width="450" align="left"><input type="text" name="txtbantitle" value="<?php print($txtbantitle);?>" style="width:250px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
						</tr>
						<tr>
							<td align="right">Link:</td>
							<td align="left"><input type="text" name="txtlink" value="<?php print($txtlink);?>" style="width:250px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
						</tr>
						<tr>
							<td align="right"> File :</td>
							<td align="left"><input type="file" name="ban_file" style="width:150px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
						</tr>
						<tr>
							<td align="right"> StartDate :</td>
							<td align="left"><input type="text" name="txtstartdate" id="txtstartdate" readonly value="<?php print($txtstartdate);?>" style="width:100px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
								<a href="javascript:cal0.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a> </td>
						</tr>
						<script language="JavaScript">
								var cal0 = new calendar1(document.forms['form1'].elements['txtstartdate']);
								cal0.year_scroll = true;
								cal0.time_comp = false;
							</script>
						<tr>
							<td align="right"> End Date :</td>
							<td align="left"><input type="text" name="txtenddate" id="txtenddate" readonly value="<?php print($txtenddate);?>" style="width:100px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
								<a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a> </td>
						</tr>
						<script language="JavaScript">
								var cal1 = new calendar1(document.forms['form1'].elements['txtenddate']);
								cal1.year_scroll = true;
								cal1.time_comp = false;
							</script>
						<tr>
							<td colspan="2" height="6"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="left"><input type="hidden" name="action" value="<?php print($_REQUEST['action']);?>">
								<?php
								if($_REQUEST['action'] == 2){
							?>
								<input type="hidden" name="filePath" value="<?php print($filePath);?>">
								<input name="btnEdit" type="submit" class="inputButton" value="SUBMIT">
								&nbsp;&nbsp;
								<?php	
								}
								else{
							?>
								<input name="btnAdd" type="submit" class="inputButton" value="SUBMIT">
								&nbsp;&nbsp;
								<?php
								}
							?>
								<input name="btnCancel" type="button" class="inputButton" value="CANCEL" onClick="javascript: window.location = '<?php print($_SERVER['HTTP_REFERER']);?>';">
							</td>
						</tr>
						<tr>
							<td colspan="3" height="10"></td>
						</tr>
					</form>
				</table>
				<?php
						}
						else{
					?>
				<table align="center" width="96%" border="0" cellpadding="2" cellspacing="0">
					<form name="frm" method="post" action="<?php print($_SERVER['PHP_SELF']);?>" onSubmit="return chkRequired(this);">
						<?php
							$Query = "SELECT b.*, c.barea_name, bt.btype_name FROM banners AS b, banner_areas AS c, banner_type AS bt WHERE c.barea_id=b.barea_id AND b.btype_id=bt.btype_id ORDER BY b.ban_id DESC";
							$counter=0;
							$limit = 20; 
							$start = $p->findStart($limit); 
							$count = mysql_num_rows(mysql_query($Query)); 
							$pages = $p->findPages($count, $limit); 
							$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
						?>
						<tr>
							<td align="right"><a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Add New">Add New</a></td>
						</tr>
						<tr>
							<td align="center"><table width="100%" align="center" cellpadding="2" cellspacing="1" class="ListTables">
									<tr>
										<td width="30" align="center" class="TableHeads"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
										<td align="center" class="TableHeads">Name</td>
										<td width="80" align="center" class="TableHeads">Area</td>
										<td width="80" align="center" class="TableHeads">Banner Type</td>
										<td width="120" align="center" class="TableHeads">File</td>
										<td width="120" align="center" class="TableHeads">StartDate</td>
										<td width="80" align="center" class="TableHeads">EndDate</td>
										<td width="80" align="center" class="TableHeads">Edit</td>
									</tr>
									<?php
							$cnt = 0;
							$clsName = "ListRow1";
							if(mysql_num_rows($rs)>0){
								while($row=mysql_fetch_object($rs)){	
									$cnt++;
									if ($cnt%2 == 0){
										$clsName = "ListRow2";
									}
									else{
										$clsName = "ListRow1";
									}
						?>
									<tr class="<?php print($clsName);?>">
										<td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->ban_id);?>"></td>
										<td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->ban_name);?></td>
										<td align="center" style="padding-left:4px;padding-right:4px;"><?php print($row->barea_name);?></td>
										<td align="center" style="padding-left:4px;padding-right:4px;"><?php print($row->btype_name);?></td>
										
                                        <td align='center' >
                                        	<?php
											if(empty($row->ban_file)){
												print("File not avalable on server!");
											}
											else{
												if($row->btype_id==2) {
											?>
                                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="120" height="120">
												<param name="movie" value="../banner/<?php echo $row->ban_file;?>" />
												<param name="quality" value="high" />
												<param name="menu" value="false" />
												<param name="wmode" value="transparent" />
												<param name="allowscriptaccess" value="always" />
												<embed src="../banner/<?php echo $row->ban_file;?>" menu="false" wmode="transparent" allowscriptaccess="always" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="120" height="120"></embed>
											</object>        
                                            <?php		
												} else {
											?>
												<img src="../banner/<?php print($row->ban_file);?>" width="120">
										<?php		
												}
											}
										?>
                                        </td>
										<td align="center" style="padding-right:4px;"><?php print($row->ban_startdate);?></td>
										<td align="center" style="padding-right:4px;"><?php print($row->ban_enddate);?>
										<td align="center"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&ban_id=".$row->ban_id);?>" title="Edit">Edit</a></td>
									</tr>
									<?php
								}
							}
							else{	
						?>
									<tr>
										<td colspan="7" align="center" class="ListRow1">No Record Found</td>
									</tr>
									<?php
							}
						?>
								</table></td>
						</tr>
						<tr>
							<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><?php print("Page <b>".$_GET['page']."</b> of ".$pages);?></td>
										<td align="right"><?php	
												$next_prev = $p->nextPrev($_GET['page'], $pages, "");
												print($next_prev);
											?>
										</td>
									</tr>
								</table></td>
						</tr>
						<tr>
							<td height="25" align="center"><input type="submit" name="btnDelete" value="DELETE" class="inputButton" onClick="return confirm('Are you sure you want to delete!');">
							</td>
						</tr>
					</form>
					<tr>
						<td height="10"></td>
					</tr>
				</table>
				<?php } ?>
			</td>
			</tr>
			
		</table></td>
	</tr>
	
	<tr>
		<td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td>
	</tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
