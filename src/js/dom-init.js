var DOM = window.DOM || {};
DOM.Methods = {};
DOM.LoadMethod = function(context){
	if( context === undefined ) {
		context = $(document);
	}

	context.find( '*[data-method]' ).each(function(){
		var that 		= $(this),
		    methods 	= that.attr('data-method');

		$.each(methods.split(" "), function(index, methodName){
			try {
				var MethodClass 	  = DOM.Methods[methodName],
				    initializedMethod = new MethodClass(that);
			}
			catch(e) {
				// blank
			}
		});
	});
};
DOM.onReady = function(){
	DOM.LoadMethod();

	document.documentElement.classList.remove('no-js');
	document.documentElement.classList.add('js');
};

export default DOM;