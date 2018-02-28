( function( $, _ ) {

	wp.CodeMirror.fromTextArea( document.getElementById( 'js-robositemap-content-robots' ), {
		lineNumbers: true,
		mode: 'shell'
	} );

	wp.CodeMirror.fromTextArea( document.getElementById( 'js-robositemap-content-sitemap' ), {
		lineNumbers: true,
		mode: 'xml'
	} );

} )( jQuery );
