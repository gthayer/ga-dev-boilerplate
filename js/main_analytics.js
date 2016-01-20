(function(window, $, undefined) {

	//Load GA Plugin. If unable to load, wait 50 milliseconds and attempt load again.
	function providePlugin(pluginName, pluginConstructor) {
		if (window.ga && document.body ) {
			ga('provide', pluginName, pluginConstructor);
		} else {
			window.setTimeout(function() {
				providePlugin('main_analytics', main_analyticsLoader);
			}, 50);
		}
	}

	// Plugin constructor.
	function main_analyticsLoader() {

		//GA plugin goes here.

	}

	// Register the plugin.
	providePlugin('main_analytics', main_analyticsLoader);

})(window, jQuery);