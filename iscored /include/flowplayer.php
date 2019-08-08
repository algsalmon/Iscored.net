<script type="text/javascript">
flowplayer("player1", "flowplayer/flowplayer-3.2.4.swf", {
	log: { level: 'debug', filter: 'org.flowplayer.slowmotion.*' },
	
	// configure the required plugins
	plugins:  {

		slowmotion: {
			url: 'flowplayer/flowplayer.slowmotion-3.2.0.swf'
		},
		
		rtmp: {
			url: 'flowplayer/flowplayer.rtmp-3.2.3.swf',
            netConnectionUrl: 'rtmp://r.iscorednew.algie.netdna-cdn.com/play'
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
		
		scaling: 'fit',
		duration: <?php print($clipDuration); ?>
	}
});

$f().onLoad(function () {
    $("#actions").css("opacity", 1);
    $("#actions button").removeAttr("disabled")
});
$f().onUnload(function () {
    $("#actions").css("opacity", 0.5);
    $("#actions button").attr("disabled", true)
});
var actions = {
    backward: function (speed) {
        $f().getPlugin('slowmotion').backward(speed)
    },
    forward: function (speed) {
        $f().getPlugin('slowmotion').forward(speed)
    },
    normal: function () {
        $f().getPlugin('slowmotion').normal()
    }
}
</script>
<?php //if($slowMotion==0){ ?>
<div id="actions" style="text-align:center;opacity:1;width:640px;margin-top: 10px;">
<button type="button" class="custom low small" disabled onclick="actions.backward(8)"> Back 8 x </button>
<button type="button" class="custom low small" disabled onclick="actions.backward(4)"> Back 4 x </button>
<button type="button" class="custom low small" disabled onclick="actions.backward(2)"> Back 2 x </button>
<button type="button" class="custom low small" disabled onclick="actions.normal()"> Normal </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(2)"> Fwd 2 x </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(4)"> Fwd 4 x </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(8)"> Fwd 8 x </button><br />
<button type="button" class="custom low large" disabled onclick="actions.backward(0.25)"> Backward 1/4 </button>
<button type="button" class="custom low large" disabled onclick="actions.backward(0.5)"> Backward half </button>
<button type="button" class="custom low large" disabled onclick="actions.forward(0.5)"> Forward half </button>
<button type="button" class="custom low large" disabled onclick="actions.forward(0.25)"> Forward 1/4 </button>
</div>
<?php //} else{ ?>
<script type="text/javascript">
//	actions.forward(0.5);
</script>
<?php //} ?>