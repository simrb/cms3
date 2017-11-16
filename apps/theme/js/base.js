//$.mobile.page.prototype.options.domCache = false;
//$.mobile.autoInitializePage = false;

$(document).bind("pagecreate", function(e) {  
    $( "input, textarea, select", e.target ).attr( "data-" + $.mobile.ns + "role", "none" );
    $( "a", e.target ).attr( "data-" + $.mobile.ns + "ajax", "false" ); 
});


$(document).ready( function() {

	// remove default style of form
	$("form").attr("data-ajax", "false");
	$("input").attr("data-role", "none");
	$("select").attr("data-role", "none");

});


