<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/VLCobject"></script>
<script type="text/javascript" src="js/VLCcontrols"></script>
<script language="javascript">
	 var vlc_controls = null;
	 function seek(pos) {
                // two ways to seek to some position (pos in seconds) : 
        		vlc_controls.target.input.time = parseInt(pos)*1000;
                // can also use this :
                //vlc_controls.target.input.position = parseInt(pos)*1000 / vlc_controls.target.input.length;
     }
     
	 
</script>

</head>
<body>

<div id="vlccontent">replaced by VLC controller</div>

<script type="text/javascript">
  var myvlc = new VLCObject("mymovie", "400", "200", "0.8.6");
  myvlc.addParam("MRL","videos/main/1_consumer_plus.flv");
  myvlc.write("vlccontent");
  var myvlccontrols = new VLCcontrols(myvlc);
  myvlc.options.set("start-time", 60);
	myvlc.onready = function () {
		myvlc.play("videos/main/1_consumer_plus.flv");
	
	}

</script>

<!--<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab" width="400" height="300" id="vlc" events="True">-->
	<!--<param name="Src" value="videos/main/1_consumer_plus.flv"></param>-->
	<!--<param name="ShowDisplay" value="True" ></param>-->
	<!--<param name="AutoLoop" value="yes"></param>-->
	<!--<param name="AutoPlay" value="yes"></param>-->
	<!--<embed type="application/x-google-vlc-plugin" name="vlc" autoplay="yes" loop="yes" width="400" height="300" target="videos/main/1_consumer_plus.flv"></embed>-->
<!--</object>-->

<script type='text/javascript'>
	/*window.onload = function(){
		var vlc = document.getElementById('vlc');
		vlc.playlist.playItem( vlc.playlist.add('videos/main/1_consumer_plus.flv') );
	};*/
	/*function pStop(){
		var vlc = document.getElementById('vlc');
		alert(vlc);
		vlc.stop();
	}*/
</script>
<!--<input type="button" value="Stop" onclick="pStop();" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />
<input type="button" value="" onclick="" />-->
</body>
</html>
