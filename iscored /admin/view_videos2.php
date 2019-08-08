<?php include("include/php_includes_top.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/html_head.php"); ?>
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
          <h3> MY VIDEOS </h3>
		 	<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
				<tr>
					<td align="center" class="TableHeads" height="28" width="30">S.No</td>
					<td align="center" class="TableHeads" height="28">Name</td>
					<td align="center" class="TableHeads" height="28">Category</td>
                     <td align="center" class="TableHeads" height="28">Date</td>                    
					<td align="center" class="TableHeads" height="28" width="60">Status</td>
				</tr>
<?php
	$count=0;
	$strClass = "ListRow1";
	$strQry = "SELECT o.*, v.vid_name, v.vid_file_path, p.pstatus_name, c.cat_name FROM orders AS o, pay_status AS p, videos AS v, categories AS c WHERE c.cat_id=o.cat_id AND p.pstatus_id=o.pstatus_id AND v.vid_id=o.vid_id AND o.mem_id=".$_SESSION['UserID']." ORDER BY o.ord_id DESC";
	//print($strQry);
	//die();
	$rs = mysql_query($strQry);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_object($rs)){
			$count++;
			if($count%2==0){
				$strClass = "ListRow1";
			}
			else{
				$strClass = "ListRow1";
			}
?>
				<tr>
					<td class="<?php print($strClass);?>" align="right" style="padding-right:2px;"><?php print($count);?></td>
					<td class="<?php print($strClass);?>" align="left"><?php print($row->vid_name);?></td>
                    <td class="<?php print($strClass);?>" align="left"><?php print($row->cat_name);?></td>
                    <td class="<?php print($strClass);?>" align="left"><?php print($row->ord_date);?></td>
					<td class="<?php print($strClass);?>" align="center"><?php print($row->pstatus_name);?></td>
				</tr>
<?php
		}
	}
?>	
				
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
