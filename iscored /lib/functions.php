<?php
function createRandomCode($limit) {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= $limit) {
        $num = rand() % 62; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    }
    return $pass; 
} 

function showTeam() {
	$retRes="";
	$countR=0;
	$strQry="SELECT team_name FROM team_played";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			$countR++;
			if($countR==1) 
				$retRes = "'".$row->team_name."'";
			else
				$retRes .= ", '".$row->team_name."'";
		}
	}	
	return $retRes;		
}

function showBanner1($areaID, $areaName){
	$strVar = '';
	$rsBan = mysql_query("SELECT * FROM banners WHERE status_id=1 AND barea_id=".$areaID." AND ban_startdate <= '".@date("Y-m-d")."' AND ban_enddate >= '".@date("Y-m-d")."' ORDER BY RAND() LIMIT 0, 1");
	if(mysql_num_rows($rsBan)>0){
		$rowBan=mysql_fetch_object($rsBan);
		if($rowBan->btype_id==2) {
			$strVar .= '
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="285" height="238">
					<param name="movie" value="banner/'.$rowBan->ban_file.'" />
					<param name="quality" value="high" />
					<param name="menu" value="false" />
					<param name="wmode" value="transparent" />
					<param name="allowscriptaccess" value="always" />
					<embed src="banner/'.$rowBan->ban_file.'" menu="false" wmode="transparent" allowscriptaccess="always" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="285" height="238"></embed>
				</object>';
		} elseif($rowBan->btype_id==3) {
			$strVar .= $rowBan->ban_embed_code;
		} else {
			$strVar .= '
				<div id="BottomLeft" align="center" class="banner_padding">
					<a href="'.$rowBan->ban_link.'" target="_blank" title="'.$rowBan->ban_name.'">
						<img src="banner/'.$rowBan->ban_file.'" border="0" alt="'.$rowBan->ban_name.'" />
					</a>
				</div>';
		}
	}
	print($strVar);
}

function updateTBL($tblName, $strUpdate, $idField, $id){
	mysql_query("UPDATE ".$tblName." SET ".$strUpdate." WHERE ".$idField."=".$id) or die(mysql_error());
}

function convert_time_seconds($varTime){
	$totalSeconds=0;
	$time = explode(".", $varTime);
	list($hour, $minute, $second) = explode(':', $time[0]);
	$hourSeconds = $hour * 60 * 60;
	$minuteSeconds = $minute * 60;
	$totalSeconds = $hourSeconds + $minuteSeconds + $second;
	return $totalSeconds;		
}


function showStatus($val){
	switch ($val) {
		case 0:
			$varStatus = "Pending";
			break;
		case 1:
			$varStatus = "Completed";
			break;
		case 2:
			$varStatus = "Failed";
			break;
		case 3:
			$varStatus = "Denied";
			break;
		case 4:
			$varStatus = "INVALID";
			break;
		case 5:
			$varStatus = "Cancelled";
			break;
		case 6:
			$varStatus = "Rejected";
			break;
	}
	return $varStatus;
}

function videoTags($ID){
	$cnt = 0;
	$strReturn = "";
	$strQuery="SELECT t.tag_name FROM video_tags AS v, tags AS t WHERE t.tag_id=v.tag_id AND v.vid_id=".$ID;
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if($cnt>0){
				$strReturn .= ", ";
			}
			$strReturn .= $row->tag_name;
			$cnt++;
		}
	}
	return $strReturn;
}

function copyDir($dir, $dest){
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$pos = strpos($file, ".");
				if($pos > 0){
					$strSource = $dir . "/" . $file;
					$strDest = $dest . "/" . $file;
					copy($strSource, $strDest);
				}
			}
		}
		closedir($handle);
	}
}

function showCardname($ID){
	$retRes = "";
	$strQry="SELECT mcard_name FROM mem_cards WHERE mcard_id=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}
	else{
		$retRes = "Card Removed";
	}
	return $retRes;	
}

function FillSelected($Table, $IDField, $TextField, $ID){   
	$strQuery="SELECT $IDField, $TextField FROM $Table ORDER BY $IDField";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if($row[0] == $ID){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}
function FillMultiple($Table, $IDField, $TextField, $SelTbl, $Field1, $Field2, $SelID){
	$strQuery="SELECT $IDField, $TextField FROM $Table";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQuery1="SELECT * FROM $SelTbl WHERE $Field1=$row[0] AND $Field2=$SelID";
			$nResult1 =mysql_query($strQuery1);
			if (mysql_num_rows($nResult1)>=1){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}
function FillSelected_Parent($Table, $IDField, $TextField, $ID){   
	$strQuery="SELECT * FROM $Table WHERE area_parentid = 0";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQry="SELECT * FROM $Table WHERE area_parentid = $row[0]";
			$nRs = mysql_query($strQry);
			if (mysql_num_rows($nRs)>=1){
				print("<optgroup label=\"$row[1]\">");
				while ($row1=mysql_fetch_row($nRs)){
					if($row1[0] == $ID){
						print("<option value=\"$row1[0]\" selected>$row1[1]</option>");
					}
					else{
						print("<option value=\"$row1[0]\">$row1[1]</option>");
					}
				}
				print("</optgroup>");
			}
			else{
				if($row[0] == $ID){
					print("<option value=\"$row[0]\" selected>$row[1]</option>");
				}
				else{
					print("<option value=\"$row[0]\">$row[1]</option>");
				}
			}
		}
	}
}
function FillSelected2($Table, $IDField, $TextField, $ID, $WHERE){
	$strQuery="SELECT $IDField, $TextField FROM $Table $WHERE";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if($row[0] == $ID){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}
function TotalRecords($Table, $condition){
	$strQuery = "SELECT * FROM $Table $condition";
	$nResult = mysql_query($strQuery);
	return mysql_num_rows($nResult);
}

function checkAdminOldPass($UserID,$Pass){
	$retRes=0;
		$strQry="SELECT admin_user, admin_pass FROM admin WHERE admin_id=$UserID AND admin_pass='$Pass'";
		$nResult =mysql_query($strQry);
		if (mysql_num_rows($nResult)>=1){
			$retRes=1;
		}
	return $retRes;		
}

function checkAdminLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT user_id FROM user WHERE user_name='$Login' AND user_password='$Pass'";
	$nResult=mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$retRes=1;
	}	
	return $retRes;		
}

function checkSAdminLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT sadmin_user FROM sec_admin WHERE sadmin_user='$Login' AND sadmin_pass='$Pass'";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->sadmin_user) 
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT mem_login FROM members WHERE mem_login='$Login' AND mem_password='$Pass'";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->mem_login)
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkLogin2($Login,$Pass){
	$retRes=0;
	$strQry="SELECT mem_login FROM members WHERE mem_login='$Login' AND mem_password='$Pass' AND mem_deleted = 1";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->mem_login)
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkSubscription($mID){
	$retRes=0;
	$strQry="SELECT sinfo_enddate, paystatus_id FROM subscription_info WHERE mem_id=$mID";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		if($row->paystatus_id > 1){
			$retRes=2;
		}
		elseif($row->paystatus_id < 1){
			$retRes=3;
		}
		elseif($row->sinfo_enddate < @date("Y-m-d")){
			$retRes=1;
		}
		else{
			$retRes=4;
		}
	}
	return $retRes;		
}

function UpdateSignIn($MemberID, $MemberEmail){
	$MaxID = getMaximum("signin_counter", "signin_id");
	
	$strQry1="UPDATE members SET mem_last_login = NOW() WHERE mem_id=$MemberID";
	$nResult1 = mysql_query($strQry1);
	
	$strQry2="INSERT INTO signin_counter(signin_id, mem_id, mem_email, signin_date) VALUES ($MaxID, $MemberID, '$MemberEmail', NOW())";
	$nResult2 = mysql_query($strQry2);
}

function updateViews($cardID, $numViews){
	$totalViews = $numViews + 1;
	mysql_query("UPDATE cards SET card_views=".$totalViews." WHERE card_id = ".$cardID) or die("Unable 2 Update Views");
}

function getRating($PhotoID){
	$Rating = 0;
	$strQry="SELECT photo_totalrating, photo_rating FROM photos WHERE photo_id = $PhotoID";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if($row->photo_totalrating > 0 && $row->photo_rating > 0) 
				$Rating = $row->photo_totalrating / $row->photo_rating;
			else
				$Rating=0;
		}
	}	
	return $Rating;	
}

function getMaximumWhere($Table,$Field, $Where){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ".$Where;
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=1;
		}
	}	
	return $maxID;	
}

function getMaximum($Table,$Field){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=1;
		}
	}	
	return $maxID;	
}

function getMaximumCatID($Table,$Field){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=2;
		}
	}	
	return $maxID;	
}

function IsExist($Field, $Table, $TblField, $Value){
	$retRes=0;
	$strQry="SELECT $Field FROM $Table WHERE $TblField = '$Value'";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_row($nResult);	
		$retRes=$row[0];
	}	
	return $retRes;		
}

function chkExist($Field, $Table, $WHERE){
	$retRes=0;
	$strQry="SELECT $Field FROM $Table $WHERE";
	$nResult=mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_row($nResult);
		//$retRes = $row[0];
		$retRes=1;
	}	
	return $retRes;		
}

function returnMulCat($ID){
	$retRes = "";
	$numCnt = 0;
	$strQry="SELECT c.cat_name FROM categories AS c, card_categories AS cc WHERE c.cat_id = cc.cat_id AND cc.card_id = $ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){	
		while($row=mysql_fetch_row($nResult)){
			if($numCnt == 0){
				$retRes.=$row[0];
			}
			else{
				$retRes.=", ".$row[0];
			}
			$numCnt++;
		}
	}	
	return $retRes;
}

function returnName($Field, $Table, $IDField, $ID){
	$retRes = "";
	$strQry="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}	
	return $retRes;	
}

function returnID($Field, $Table, $NameField, $Name){
	$strQry="SELECT $Field FROM $Table WHERE $NameField='$Name'";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}	
	return $retRes;		
}

function countCategories($Field, $qryText){
	$strQry="SELECT CatID, CatName FROM Categories WHERE ParentID = $Field $qryText";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

function countSubCategories($Field){
	$strQry="SELECT CatID, CatName FROM Categories WHERE ParentID = $Field";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

// Return Number of products in Category
function countProducts($CatID){
	$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = PC.CatID AND P.ProID = PC.ProID AND PC.CatID = $CatID";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

// Return Number of products in Category and its Sub Category
function countProducts1($CatID){
	//$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = PC.CatID AND P.ProID = PC.ProID AND PC.CatID = $CatID AND C.ParentID = $CatID";
	$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = $CatID AND PC.CatID = C.CatID AND P.ProID = PC.ProID OR C.ParentID = $CatID AND PC.CatID = C.CatID AND P.ProID = PC.ProID";
	//print($strQry);
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}
// function for file deletion
function DeleteFile($Field,$Table,$IDField,$ID){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	//	print($strQuery);
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		//print($row->$Field);
		$fPath = "../".$row->$Field;
		@unlink($fPath);
	}
}
// function for file deletion
function DeleteFileWithThumb($Field, $Table, $IDField, $ID, $iPath, $tPath){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	//	print($strQuery);
	$nResult = mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row = mysql_fetch_object($nResult);
		$fPath = $iPath.$row->$Field;
		@unlink($fPath);
		if($tPath != "EMPTY"){
			$fPath = $tPath.$row->$Field;
			@unlink($fPath);	
		}
	}
}
// function for file deletion
function DeleteFile2($Field, $Table, $IDField, $ID, $path){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		$iPath = $path.$row->$Field;
		@unlink($iPath);
		$tPath = $path."th/".$row->$Field;
		@unlink($tPath);
	}
}
function Fill($Table, $IDField, $TextField, $chkSelected){
	$strQuery="SELECT $IDField, $TextField FROM $Table ORDER BY $IDField";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if ($chkSelected == $row[0]){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}

function ImageSize($imagesource, $DisplayH, $DisplayW){
	list($width, $height, $type, $attr) = getimagesize($imagesource);
	$wid = $width;
	$hig = $height;
	
	if($wid > $DisplayW || $hig > $DisplayH){
		if($wid <= $hig){
			$img_ratio = $wid / $hig;
			$newHeight = $DisplayH;
			$temp = $newHeight * $img_ratio;
			$newWidth = round($temp);
		}
		else{
			$img_ratio = $hig / $wid;
			$newWidth = $DisplayW;
			$temp = $newWidth * $img_ratio;
			$newHeight = round($temp);
		}
	}
	else{
		$newHeight = $hig;
		$newWidth = $wid;
	}
	
	$showimage = "<img src=\"".$imagesource."\" height=\"".$newHeight."\" width=\"".$newWidth."\" class=\"img\">";
	return $showimage;
}

function IncreaseViews($Table, $CounterFeild, $IDField, $ID){
	$Query = "UPDATE $Table SET $CounterFeild = $CounterFeild+1 WHERE $IDField = $ID";
	$nRst=mysql_query($Query) or die("Unable 2 Edit Record");
}

function GetViews($Field, $Table, $IDField, $ID){
	$strQry="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$rs=mysql_fetch_object($nResult);
		print($rs->$Field);
	}	
}

function SelectDate($emonth, $eday){
	print("<select name=\"month1\" class=\"inputsmallBorder\">");
	for($i=1; $i<=12; $i++) {
		if($emonth == $i){
			print("<option value=\"$i\" selected>$i</option>");
		}
		else{
			print("<option value=\"$i\">$i</option>");
		}
	}
	print("</select>&nbsp;");
	
	print("<select name=\"day1\" class=\"inputsmallBorder\">");
	for($i=1; $i<=31; $i++) {
		if ($eday == $i){
			print("<option value=\"$i\" selected>$i</option>");
		}
		else{
			print("<option value=\"$i\">$i</option>");
		}
	}
	print("</select>");
}

function Display_Alphabets($char, $QryString){
	$count = 0;
	$linksHTML = "";
	$char_array = array();
		$char_array[0]	=	"A";
		$char_array[1]	=	"B";
		$char_array[2]	=	"C";
		$char_array[3]	=	"D";
		$char_array[4]	=	"E";
		$char_array[5]	=	"F";
		$char_array[6]	=	"G";
		$char_array[7]	=	"H";
		$char_array[8]	=	"I";
		$char_array[9]	=	"J";
		$char_array[10]	=	"K";
		$char_array[11]	=	"L";
		$char_array[12]	=	"M";
		$char_array[13]	=	"N";
		$char_array[14]	=	"O";
		$char_array[15]	=	"P";
		$char_array[16]	=	"Q";
		$char_array[17]	=	"R";
		$char_array[18]	=	"S";
		$char_array[19]	=	"T";
		$char_array[20]	=	"U";
		$char_array[21]	=	"V";
		$char_array[22]	=	"W";
		$char_array[23]	=	"X";
		$char_array[24]	=	"Y";
		$char_array[25]	=	"Z";

	$linksHTML = "<table width=\"98%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\"><tr>";
	while ($count < count($char_array)) {
		if($char == $char_array[$count]) {
			$linksHTML .= "<td align=\"center\" class=\"charSelected\">".$char_array[$count]."</td>";
		}
		else{
			if($QryString != ""){
				$linksHTML .= "<td align=\"center\" class=\"char\"><a href=\"".$_SERVER['PHP_SELF']."?char=".$char_array[$count]."&".$QryString."\" title=\"".$char_array[$count]."\">".$char_array[$count]."</a></td>";
			}
			else{
				$linksHTML .= "<td align=\"center\" class=\"char\"><a href=\"".$_SERVER['PHP_SELF']."?char=".$char_array[$count]."\" title=\"".$char_array[$count]."\">".$char_array[$count]."</a></td>";
			}
		}
		$count++;
	}

	
	$linksHTML .= "</tr></table>";
	print($linksHTML);
}

function showBanner($location, $showOne){
	// show random banner where status is 1
	if($showOne == 0){
		$stringQry="SELECT * FROM banner WHERE status_id = 1 AND bloc_id = ".$location;
	}
	else{
		$stringQry="SELECT * FROM banner WHERE status_id = 1 AND bloc_id = ".$location." ORDER BY RAND()";
	}
	$nRst = mysql_query($stringQry);
	if(mysql_num_rows($nRst)>=1){
		print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">");
		while($rowb=mysql_fetch_object($nRst)){
			$totalView = $rowb->banner_display + 1;
			$banID = $rowb->banner_id;
			print("<tr>");
			print("<td>");
			if($rowb->bformat_id == 2){
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\">");
				print("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" border=\"0\">");
				print("<param name=\"movie\" value=\"".$rowb->banner_source."\">");
				print("<param name=\"quality\" value=\"high\">");
				print("<embed src=\"".$rowb->banner_source."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed></object>");
				print("</a>");
			}
			else{
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\"><img src=\"".$rowb->banner_source."\" alt=\"".$rowb->banner_alttext."\" border=\"0\" align=\"absbottom\" class=\"img\"></a>");
			}
		print("		</td>");
		print("	</tr>");
		print("<tr><td height=\"10\"></td></tr>");
		}
	print("</table>");
	mysql_query("UPDATE banner SET banner_display=".$totalView." WHERE banner_id = ".$banID);
	}
}

function showBanner2($btype){
	// show random banner where status is 1
	$stringQry="SELECT * FROM banners WHERE status_id = 1 AND ban_start_date <= '".@date("Y-m-d")."' AND ban_end_date >= '".@date("Y-m-d")."' AND btype_id = ".$btype." ORDER BY RAND()";
	$nRst = mysql_query($stringQry);
	if(mysql_num_rows($nRst)>=1){
		print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">");
		while($rowb=mysql_fetch_object($nRst)){
			$totalView = $rowb->ban_display + 1;
			$banid = $rowb->ban_id;
			print("<tr>");
			print("<td>");
		/*	
			if($rowb->bformat_id == 2){
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\">");
				print("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" border=\"0\">");
				print("<param name=\"movie\" value=\"".$rowb->banner_source."\">");
				print("<param name=\"quality\" value=\"high\">");
				print("<embed src=\"".$rowb->banner_source."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed></object>");
				print("</a>");
			}
			else{
		*/
				print("<a href=\"bannerclick.php?banid=".$banid."&url=".$rowb->ban_link."\" target=\"_blank\"><img src=\"banner_files/".$rowb->ban_image."\" alt=\"".$rowb->ban_alt_text."\" border=\"0\" align=\"absbottom\" class=\"img\"></a>");
		//	}
		print("		</td>");
		print("	</tr>");
		print("<tr><td height=\"10\"></td></tr>");
		}
	print("</table>");
	mysql_query("UPDATE banners SET ban_display=".$totalView." WHERE ban_id = ".$banid);
	}
}

function createThumbnail($imageDirectory, $imageName, $thumbDirectory, $thumbWidth){
$srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
$origWidth = imagesx($srcImg);
$origHeight = imagesy($srcImg);

$ratio = $origWidth / $thumbWidth;
$thumbHeight = $origHeight * $ratio;

$thumbImg = imagecreate($thumbWidth, $thumbHeight);
imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($thumbImg), imagesy($thumbImg));

imagejpeg($thumbImg, "$thumbDirectory/$imageName");
}

function createThumbnail2($imageDirectory, $imageName, $thumbDirectory, $thumbWidth, $thumbHeight){
	$srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
	$sourceWidth = imagesx($srcImg);
	$sourceHeight = imagesy($srcImg);
	
	if($sourceHeight > $sourceWidth){
		$ratio = $sourceHeight / $thumbHeight;
		$tmpWidth = $sourceWidth / $ratio;
		if($tmpWidth > $thumbWidth){
			$ratio = $sourceWidth / $thumbWidth;
			$thumbHeight = round($sourceHeight / $ratio);
		}
		else{
			$thumbWidth = $tmpWidth;
		}
	}
	else{
		$ratio = $sourceWidth / $thumbWidth;
		$tmpHeight = $sourceHeight / $ratio;
		if($tmpHeight > $thumbHeight){
			$ratio = $sourceHeight / $thumbHeight;
			$thumbWidth = round($sourceWidth / $ratio);
		}
		else{
			$thumbHeight = $tmpHeight;
		}
	}
	
	$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
	imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($srcImg), imagesy($srcImg));
	
	imagejpeg($thumbImg, $thumbDirectory.$imageName);
}

//createThumbnail("img", "theFileName.jpg", "img/thumbs", 100);

?>
