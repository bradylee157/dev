var MyPiBox = {
   pioptions: {
		onOpen: $empty,
		onClose: $empty,
		onUpdate: $empty,
		onResize: $empty,
		onMove: $empty,
		onShow: $empty,
		onHide: $empty,
		size: {x: 960, y: 600},
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

SqueezeBox.extend({
	applyContent: function(content, size) {
		if (!this.isOpen && !this.applyTimer) return;
		this.applyTimer = $clear(this.applyTimer);
		this.hideContent();
		if (!content) {
			this.toggleLoading(true);
		} else {
			if (this.isLoading) this.toggleLoading(false);
			this.fireEvent('onUpdate', [this.content], 20);
		}
		if (content) {
			if (typeOf(content) == 'string' || typeOf(content) == 'array') {
				this.content.set('html', content);
			} else if (typeOf(content) == 'element' &&
!this.content.hasChild(content)) {
				this.content.adopt(content);
			} else {
				this.content.set('html', '');
			}
		}
		this.callChain();
		if (!this.isOpen) {
			this.toggleListeners(true);
			this.resize(size, true);
			this.isOpen = true;
			this.fireEvent('onOpen', [this.content]);
		} else {
			this.resize(size);
		}
	}
});

window.addEvent('domready', function() {
    var pioptions = MyPiBox.pioptions;
    SqueezeBox.initialize(pioptions);
});
