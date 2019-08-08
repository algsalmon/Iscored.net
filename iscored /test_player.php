<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/flowplayer-3.2.0.min.js"></script>
</head>
<body>
<!--<object width="400" height="300" id="_player" name="_player" data="http://releases.flowplayer.org/swf/flowplayer-3.2.2.swf" type="application/x-shockwave-flash">
	<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.2.swf" />
	<param name="allowfullscreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<param name="flashvars" value='config={"clip":{"url":"videos/main/1_consumer_plus.flv"},"playlist":[{"url":"videos/main/1_consumer_plus.flv"}]}' />
</object>
-->
<div style="width:425px;height:300px;" id="player"></div>

<script language="JavaScript">
	/*flowplayer(
		"player", 
		"flowplayer-3.2.2.swf", 
		"videos/main/1_consumer_plus.flv"
	);*/
	
flowplayer("player", "http://releases.flowplayer.org/swf/flowplayer-3.2.2.swf", {
	log: { level: 'debug', filter: 'org.flowplayer.slowmotion.*' },
	
	// configure the required plugins
	plugins:  {

		slowmotion: {
			url: 'flowplayer.slowmotion-3.2.0.swf'
		},
		
		rtmp: {
			url: 'flowplayer.rtmp-3.2.1.swf',
			
			// HDDN supports slow motion
            netConnectionUrl: 'rtmp://vod01.netdna.com/play'
	
		},
		
		// add a content plugin to show speed information (this is optional)
		speedIndicator: {
			url: 'flowplayer.content-3.2.0.swf',
			bottom: 50,
			right: 15,
			width: 135,
			height: 30,
			border: 'none',
			style: { 
				body: { 
					fontSize: 12, 
					fontFamily: 'Arial',
					textAlign: 'center',
					color: '#ffffff'
				} 
			},
			
			backgroundColor: 'rgba(20, 20, 20, 0.5)',
			
			// we don't want the plugin to be displayed by default, 
			// only when a speed change occur.
			display: 'none'
		},
		
		controls: {
			// enable tooltips for the buttons
			tooltips: { buttons: true }
		}

	},

	clip: {
	    // use the RTMP plugin
		provider: 'rtmp',
		
		scaling: 'orig'
	}
});
</script>

</body>
</html>
