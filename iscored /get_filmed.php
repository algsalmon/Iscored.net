<?php 
include("include/php_includes_top.php");
$strMSG='';
$class='';
if(isset($_REQUEST['strMSG']))
	$strMSG=$_REQUEST['strMSG'];

if(isset($_REQUEST['class']))
	$class=$_REQUEST['class'];

if(isset($_REQUEST['mem_id']) && isset($_REQUEST['activate']) && isset($_REQUEST['ver_code'])){
	$chk = chkExist("mem_id", "team_mem", "WHERE mem_id=".$_REQUEST['mem_id']);
	$chk_code = chkExist("ver_code", "team_mem", "WHERE mem_id=".$_REQUEST['mem_id']." AND ver_code='".$_REQUEST['ver_code']."'");
	$strHead = "Email Confirmation";
	$strMSG = "No record found.";
	if($chk >= 1 && $chk_code >= 1) {
		$chkCon = returnName("verified", "team_mem", "mem_id", $_REQUEST['mem_id']);
		if($chkCon == 0){
			$strQRY="UPDATE team_mem SET verified = 1 WHERE mem_id = ".$_REQUEST['mem_id'];
			$nRst=mysql_query($strQRY) or die($strMSG = "Confirmation Error, Please Try Later");
			$class='notification success';
			$strMSG = "<p><strong>Confirmation Success!</strong> Your email has been confirmed successfully.</p>";
		}
		else{
			$class='notification information';
			$strMSG = "<p><strong>Confirmation Overwrite!</strong> Your email address is already confirmed.</p>";
		}
	}
	else if($chk < 1) {
		$class='notification error';
		$strMSG = "<p><strong>Confirmation Error!</strong> No Record Found Regarding To Your Entry. Please Try After Some Time.</p>";
	}
	else {
		$class='notification error';
		$strMSG = "<p><strong>Confirmation Error!</strong> Confirmation Code Error. Please Try After Some Time.</p>";
	}
}
if(isset($_REQUEST['btnRegister'])){
	if(isset($_REQUEST['match'])) {
		$txtname_f=str_replace("'", "&#39;", $_REQUEST['txtname_f']);
		$txtname_l=str_replace("'", "&#39;", $_REQUEST['txtname_l']);
		$txtlogin=str_replace("'", "&#39;", $_REQUEST['txtlogin']);
		if(TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']." AND mem_email='".$txtlogin."'")>0) {
			$class='notification error';
			$strMSG = "<strong>Error!</strong> Email Address already exist!";
		}
		else {
			$mem_id = getMaximum("team_mem","mem_id");
			$rendCode = createRandomCode(10);
			SendConfirmation("ISCORED", "i-scored.net", $txtname_f, $txtlogin, $mem_id, $rendCode);
			$queryEX = ("INSERT INTO team_mem (mem_id, mem_name_f, mem_name_l, mem_email, cast_id, ver_code) VALUES(".$mem_id.", '".$txtname_f."', '".$txtname_l."', '".$txtlogin."', ". $_REQUEST['cast_id'].", '".$rendCode."')");
			mysql_query($queryEX) or die(header("Location: get_filmed.php?match&cast_id".$_REQUEST['cast_id']."=&strMSG=Wrong Entry"));
			if(TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']) >= 10) {
				$class='notification success';
				$strMSG = "<strong>Registered Successfully!</strong> Your request to have your match filmed is complete, we'll send a camera man to your <br />
							chosen match once a total of ten of your teammates have requested a match be filmed.<br />
				Postal Code: ".returnName("post_code","team_cast","cast_id",$_REQUEST['cast_id']);
			}
			else {
				header("Location: get_filmed.php?match&cast_id=".$_REQUEST['cast_id']);
			}
		}
	}
	else {
		$txtname_f=str_replace("'", "&#39;", $_REQUEST['txtname_f']);
		$txtname_l=str_replace("'", "&#39;", $_REQUEST['txtname_l']);
		$txtlogin=str_replace("'", "&#39;", $_REQUEST['txtlogin']);
		$txtname_t=str_replace("'", "&#39;", $_REQUEST['txtname_t']);
		$post_code=str_replace("'", "&#39;", $_REQUEST['post_code']);
		$tel_num=str_replace("'", "&#39;", $_REQUEST['tel_num']);
		$team_id = IsExist("team_id", "team_played", "team_name", $txtname_t);
		if(!$team_id){
			$team_id = getMaximum("team_played","team_id");
			mysql_query("INSERT INTO team_played (team_id, team_name) VALUES(".$team_id.", '".$txtname_t."')");
		}
		$cast_id = getMaximum("team_cast","cast_id");
		$queryEXN="INSERT INTO team_cast(cast_id, team_id, post_code) VALUES(".$cast_id.", ".$team_id.", ".$post_code.")";
		mysql_query($queryEXN) or die(header("Location: get_filmed.php?cast_id=".$cast_id."&strMSG=<strong>Wrong Entry</strong>&class=notification error"));
		$mem_id = getMaximum("team_mem","mem_id");
		$rendCode = createRandomCode(10);
		SendConfirmation("ISCORED", "i-scored.net", $txtname_f, $txtlogin, $mem_id, $rendCode);
		$queryEX = ("INSERT INTO team_mem (mem_id, mem_name_f, mem_name_l, mem_email, cast_id, ver_code) VALUES(".$mem_id.", '".$txtname_f."', '".$txtname_l."', '".$txtlogin."', ".$cast_id.", '".$rendCode."')");
		mysql_query($queryEX) or die(header("Location: get_filmed.php?cast_id=".$cast_id."&strMSG=<strong>Wrong Entry</strong>&class=notification error"));
		header("Location: get_filmed.php?match&cast_id=".$cast_id);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php include("include/html_head.php"); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <style type="text/css" media="all">
		#docs {
		  display: block;
		  position: absolute;
		  bottom: 0;
		}
        .ui-autocomplete { 
            position: absolute; 
            cursor: default; 
            height: 150px; 
            overflow-y: scroll; 
            overflow-x: hidden;
        }
        span { width: 10em; float: bottom; }
        span.error { float: none; color:red; padding-left: .5em; vertical-align: top; }
        p { clear: both; }
        .submit { margin-left: 12em; }
        em { font-weight: bold; padding-right: 1em; vertical-align: top; }
    </style>
	<script type="text/javascript">
        $(document).ready(function(){
			$("#getFilmed").validate();
		});
	</script>
	<script type="text/javascript">
        $(document).ready(function(){			
			var source = [<?php echo showTeam();?>];
			$("#myDropDown").autocomplete({
				minLength: 0,
				source: source,
				autoFocus: true,
				scroll: true,
			}).focus(function() {
				$(this).autocomplete("search", "");
			}).live("blur", function(event) {
				var autocomplete = $(this).data("autocomplete");
				var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i");
				autocomplete.widget().children(".ui-menu-item").each(function() {
					//Check if each autocomplete item is a case-insensitive match on the input
					var item = $(this).data("item.autocomplete");
					if (matcher.test(item.label || item.value || item)) {
						//There was a match, lets stop checking
						autocomplete.selectedItem = item;
						return;
					}
				});
				//if there was a match trigger the select event on that match
				if (autocomplete.selectedItem) {
					autocomplete._trigger("select", event, {
						item: autocomplete.selectedItem
					});
				//there was no match, clear the input
				}
			});
		});
    </script>
</head>

<body>
<div id="container">
  <div id="inner">
    <?php include("include/header.php"); ?>
    <!--content start here-->
    <div id="container">
      <div id="content_inner">
        <!--content_left_side start here-->
        <div id="content_left_side">
          <h3> Get your match filmed for free </h3>
		  <div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
			<?php 
            if(isset($_REQUEST['match'])) {
				if(TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']) <= 10) {
					?>
					<p>Please enter your friends/ teammates name & email here to ask them to request too. After More then 10 verified requests we'll send a camera man for free. To Verify Email, members have to folow the instruction, sent to their mail box. <?php echo TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']."");?> Member(s) Registered! <?php echo TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']." AND verified=1");?> Member(s) Verified!</p>
					<?php
				}
				else {
					?>
					<p>Please enter your friends/ teammates name & email here to ask them to request too. We'll send a camera man for free on this Match, If regestered 10 Members verify their Email. To Verify Email, members have to folow the instruction, sent to their mail box. <?php echo TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']);?> Member(s) Registered! <?php echo TotalRecords("team_mem", "WHERE cast_id=".$_REQUEST['cast_id']." AND verified=1");?> Member(s) Verified!</p>
					<?php
				}
            }
            else if(isset($_REQUEST['matchtime'])) {
				?>
				<p>Please Enter the Match time.</p>
				<?php
			}
            else {
				?>
				<p>Please fill the form below to Register</p>
				<?php
			}
			?>
          <br />
		  <table width="100%" border="0" cellpadding="2" cellspacing="0">
			<form id="getFilmed" name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onsubmit="$('span.error').html('');" >
				<tr><td colspan="2" align="center" class="clsred"><div class="<?php print($class);?>"><?php print($strMSG);?></div></td></tr>
				<?php 
                if(isset($_REQUEST['match'])) {
	                ?>
                    <tr>
                        <td align="right">First Name: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtname_f" id="txtname_f" value="" class="input required" style="width:280px;"  /></td>
                    </tr>
                    <tr>
                        <td align="right">Last Name: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtname_l" id="txtname_l" value="" class="input required" style="width:280px;"  /></td>
                    </tr>
                    <tr>
                        <td align="right">Enter Email Address: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtlogin" id="txtlogin" value="" class="input required email" style="width:280px;"  /></td>
                    </tr>
                    <tr>
                        <td align="right"></td>
                        <td height="40">
                            <input type="submit" name="btnRegister" value="Submit >> >>" />
                        </td>
                    </tr>
					<?php
                } else {
					?>
                    <tr>
                        <td align="right">First Name: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtname_f" id="txtname_f" class="input required" style="width:280px;" value="<?php print(@$txtname_f); ?>"   /></td>
                    </tr>
                    <tr>
                        <td align="right">Last Name: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtname_l" id="txtname_l" class="input required" style="width:280px;" value="<?php print(@$txtname_l); ?>"   /></td>
                    </tr>
                    <tr>
                        <td align="right" width="180">Email Address: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="txtlogin" id="txtlogin" class="input required email" style="width:280px;" value="<?php print(@$txtlogin); ?>"   /></td>
                    </tr>
                    <tr>
                        <td align="right">Telephone Number: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="tel_num" id="tel_num" class="input required number" style="width:280px;" value="<?php print(@$tel_num); ?>"   /></td>
                    </tr>
                    <tr>
                        <td align="right">Team Name: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input id="myDropDown" type="text" name="txtname_t" class="input required" style="width:280px;" value="<?php print(@$txtname_t); ?>"    /></td>
                    </tr>
                    <tr>
                        <td align="right">Postal Code: </td>
                        <td><img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /><input type="text" name="post_code" id="post_code" class="input required digits" style="width:280px;" value="<?php print(@$post_code); ?>"   /></td>
                    </tr>
                    <tr>
                        <td align="right"></td>
                        <td height="40">
                                <input type="submit" name="btnRegister" value="Submit >> >>" />
                        </td>
                    </tr>
					<?php
                }
                ?>
			</form>
			</table>
        </div>
        <!--content_left_side end here-->
        <div id="content_right_side">
          <?php include("include/right.php"); ?>
        </div>
      </div>
    </div>
    <!--content end here-->
    <?php include("include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<?php include("include/php_includes_bottom.php"); ?>
