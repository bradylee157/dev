var MyTeBox = {
    
   teoptions: {
		onOpen: $empty,
		onClose: $empty,
		onUpdate: $empty,
		onResize: $empty,
		onMove: $empty,
		onShow: $empty,
		onHide: $empty,
		size: {x: tescreenwidth(), y: tescreenheight()},
		sizeLoading: {x: 200, y: 150},
		marginInner: {x: 20, y: 20},
		marginImage: {x: 50, y: 75},
		handler: 'iframe',
		target: null,
		closable: true,
		closeBtn: true,
		zIndex: 65555,
		overlayOpacity: 0.7,
		classWindow: '',
		classOverlay: '',
		overlayFx: {},
		resizeFx: {},
		contentFx: {},
		parse: false, // 'rel'
		parseSecure: false,
		shadow: true,
		document: null,
		ajaxOptions: {}
	}
}

window.addEvent('domready', function() {
    var teoptions = MyTeBox.teoptions;
    SqueezeBox.initialize(teoptions);
});

function tescreenwidth()
{
   var width = 960;
   if (screen.width < 1000 )
   {width = screen.width - 100;}
   return width;
}

function tescreenheight()
{
   var height = 600;
   if (screen.height < 900)
   {height = screen.height - 300;}
   return height;
}
