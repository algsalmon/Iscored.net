<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print(SITE_TITLE);?></title>
<meta name="keywords" content="<?php print(SITE_META_KEYWORDS);?>">
<meta name="description" content="<?php print(SITE_META_DESCRIPTION);?>">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script language="javascript" src="js/ajax.js" type="text/javascript"></script>
<script language="javascript" src="lib/functions.js" type="text/javascript"></script>
<script language="javascript">
function showHideTab(objDiv, varTotal) {
	for(var i=0;i < varTotal;i++){
		if(i==objDiv){
			document.getElementById("tab["+i+"]").className = "selected";
			document.getElementById("tdata["+i+"]").style.visibility = "visible";
			document.getElementById("tdata["+i+"]").style.display = "block";	
		}
		else{
			document.getElementById("tab["+i+"]").className = "";
			document.getElementById("tdata["+i+"]").style.visibility = "hidden";
			document.getElementById("tdata["+i+"]").style.display = "none";
		}
	}
}
</script>
<script type="text/javascript" src="js/flowplayer-3.2.4.min.js"></script>
<script type="text/javascript" src="js/VLCobject.js"></script>
<script type="text/javascript" src="js/VLCcontrols.js"></script>