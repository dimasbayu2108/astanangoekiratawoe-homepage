/* global jQuery:false */
/* global SCIENTIA_STORAGE:false */

jQuery( window ).on( 'load', function() {
	"use strict";
	scientia_gutenberg_first_init();
	// Create the observer to reinit visual editor after switch from code editor to visual editor
	var scientia_observers = {};
	if (typeof window.MutationObserver !== 'undefined') {
		scientia_create_observer('check_visual_editor', jQuery('.block-editor').eq(0), function(mutationsList) {
			var gutenberg_editor = jQuery('.edit-post-visual-editor:not(.scientia_inited)').eq(0);
			if (gutenberg_editor.length > 0) scientia_gutenberg_first_init();
		});
	}

	function scientia_gutenberg_first_init() {
		var gutenberg_editor = jQuery( '.edit-post-visual-editor:not(.scientia_inited)' ).eq( 0 );
		if ( 0 == gutenberg_editor.length ) {
			return;
		}
		jQuery( '.editor-block-list__layout' ).addClass( 'scheme_' + SCIENTIA_STORAGE['color_scheme'] );
		gutenberg_editor.addClass( 'sidebar_position_' + SCIENTIA_STORAGE['sidebar_position'] );
		if ( SCIENTIA_STORAGE['expand_content'] > 0 ) {
			gutenberg_editor.addClass( 'expand_content' );
		}
		if ( SCIENTIA_STORAGE['sidebar_position'] == 'left' ) {
			gutenberg_editor.prepend( '<div class="editor-post-sidebar-holder"></div>' );
		} else if ( SCIENTIA_STORAGE['sidebar_position'] == 'right' ) {
			gutenberg_editor.append( '<div class="editor-post-sidebar-holder"></div>' );
		}

		gutenberg_editor.addClass('scientia_inited');
	}

	// Create mutations observer
	function scientia_create_observer(id, obj, callback) {
		if (typeof window.MutationObserver !== 'undefined' && obj.length > 0) {
			if (typeof scientia_observers[id] == 'undefined') {
				scientia_observers[id] = new MutationObserver(callback);
				scientia_observers[id].observe(obj.get(0), { attributes: false, childList: true, subtree: true });
			}
			return true;
		}
		return false;
	}
} );
