<div id="left-nav">
	<h1>INSTRUMENT</h1>
	<ul>
<?php
$i=0;
$CatRs = mysql_query("SELECT * FROM categories WHERE status_id=1 ORDER BY cat_id");
$NR = mysql_num_rows($CatRs);
if($NR > 0){
	while($CatD=mysql_fetch_object($CatRs)){
		$i++;
?>
		<li><a href="javascript: funcdispro(<?php echo $i;?>, <?php echo $NR;?>)"><?php echo $CatD->cat_name;?> </a> 
		<div style="display:none;" id="subcatdiv<?php echo $i;?>">
			<!--<ul>
				<?php
					//$mRs = mysql_query("SELECT m.man_id, m.man_name FROM manufacturer AS m, man_to_cat AS mc WHERE m.status_id=1 AND m.man_id=mc.man_id AND mc.cat_id=".$CatD->cat_id." ORDER BY mc.mc_order");
					$mRs = mysql_query("SELECT m.man_id, m.man_name FROM manufacturer AS m, man_to_cat AS mc WHERE m.status_id=1 AND m.man_id=mc.man_id ORDER BY mc.mc_order");
					$numR = mysql_num_rows($mRs);
					if($numR > 0){
						while($mRow=mysql_fetch_object($mRs)){
				?>
				<li><a href="products.php?cid=<?php echo $CatD->cat_id;?>&manid=<?php echo $mRow->man_id;?>"><?php echo $mRow->man_name; ?></a></li>
				<?php } } else {echo "<li>Sorry No Record Found</li>";}?>
			</ul>-->
		</div>
		</li>
<?php
	}
}
?>
	</ul>
</div>
