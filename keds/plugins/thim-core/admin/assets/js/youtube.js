var Thim_Video_Youtube = (function () {
	return {
		createPlayer: createPlayer
	};

	function createPlayer(args) {
		var height = args.height || 315;
		var width = args.width || '100%';

		return player = new YT.Player(args.id, {
			height: height,
			width: width,
			videoId: args.id,
			events: args.events
		});
	}
})();