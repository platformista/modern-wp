/* global jQuery, _ */
( function( $, _ ) {
	'use strict';

	var $wrapper,
		group = {
			toggle: {}, // Toggle module for handling collapsible/expandable groups.
			clone: {}   // Clone module for handling clone groups.
		};

	/**
	 * Handles a click on either the group title or the group collapsible/expandable icon.
	 * Expects `this` to equal the clicked element.
	 *
	 * @param event Click event.
	 */
	group.toggle.handle = function( event ) {
		event.preventDefault();
		event.stopPropagation();

		var $group = $( this ).closest( '.rwmb-group-clone, .rwmb-group-non-cloneable' ),
			state = $group.hasClass( 'rwmb-group-collapsed' ) ? 'expanded' : 'collapsed';

		group.toggle.updateState( $group, state );
	};

	/**
	 * Update the group expanded/collapsed state.
	 *
	 * @param $group Group element.
	 * @param state  Force group to have a state.
	 */
	group.toggle.updateState = function( $group, state ) {
		if ( state ) {
			$group.find( '> .rwmb-hidden-wrapper input' ).val( state );
		} else {
			state = $group.find( '> .rwmb-hidden-wrapper input' ).val();
		}

		$group.toggleClass( 'rwmb-group-collapsed', 'collapsed' === state )
		      .children( '.rwmb-group-toggle-handle' ).attr( 'aria-expanded', 'collapsed' !== state );
	};

	/**
	 * Update group title.
	 *
	 * @param index   Group clone index.
	 * @param element Group element.
	 */
	group.toggle.updateTitle = function ( index, element ) {
		var $group = $( element ),
			$title = $group.find( '> .rwmb-group-title, > .rwmb-input > .rwmb-group-title' ),
			options = $title.data( 'options' ),
			content;

		if ( 'text' === options.type ) {
			content = options.content.replace( '{#}', index );
		}
		if ( 'field' === options.type ) {
			var fieldId = $title.data( 'options' ).field,
				$field = $group.find( ':input[name*="[' + fieldId + ']"]' );

			content = $field.val();

			// Update title when field's value is changed.
			if ( ! $field.data( 'update-group-title' ) ) {
				$field.on( 'keyup', _.debounce( function () {
					group.toggle.updateTitle( 0, element );
				}, 250 ) ).data( 'update-group-title', true );
			}
		}
		$title.text( content );
	};

	/**
	 * Initialize the title on load or when new clone is added.
	 *
	 * @param container Wrapper (on load) or group element (when new clone is added)
	 */
	group.toggle.initTitle = function ( container ) {
		$( container ).find( '.rwmb-group-collapsible' ).each( function () {
			// Update group title for non-cloneable groups.
			if ( $( this ).hasClass( 'rwmb-group-non-cloneable' ) ) {
				group.toggle.updateTitle( 1, this );
				group.toggle.updateState( $( this ) );
				return;
			}

			$( this ).children( '.rwmb-input' ).each( function () {
				// Update group title.
				$( this ).children( '.rwmb-group-clone' ).each( function ( index, clone ) {
					group.toggle.updateTitle( index + 1, clone );
					group.toggle.updateState( $( clone ) );
				} );

				// Drag and drop clones via group title.
				$( this ).sortable( 'option', 'handle', '.rwmb-clone-icon + .rwmb-group-title' );
			} );
		} );
	};

	/**
	 * Update group index for inputs
	 */
	group.clone.updateGroupIndex = function () {
		var that = this,
			$clones = $( this ).parents( '.rwmb-group-clone' ),
			totalLevel = $clones.length;
		$clones.each( function ( i, clone ) {
			var index = parseInt( $( clone ).parent().data( 'next-index' ) ) - 1,
				level = totalLevel - i;
			group.clone.replaceName.call( that, level, index );

			// Stop each() loop immediately when reach the new clone group.
			if ( $( clone ).data( 'clone-group-new' ) ) {
				return false;
			}
		} );
	};

	group.clone.updateIndex = function() {
		var $this = $( this );

		// Update index only for sub fields in a group
		if ( ! $this.closest( '.rwmb-group-clone' ).length ) {
			return;
		}

		// Do not update index if field is not cloned
		if ( ! $this.closest( '.rwmb-input' ).children( '.rwmb-clone' ).length ) {
			return;
		}

		var index = parseInt( $this.closest( '.rwmb-input' ).data( 'next-index' ) ) - 1,
			level = $this.parents( '.rwmb-clone' ).length;
		group.clone.replaceName.call( this, level, index );

		// Stop propagation.
		return false;
	};

	/**
	 * Helper function to replace the level-nth [\d] with the new index.
	 * @param level
	 * @param index
	 */
	group.clone.replaceName = function ( level, index ) {
		var $input = $( this ),
			name = $input.attr( 'name' );
		if ( ! name ) {
			return;
		}

		var regex = new RegExp( '((?:\\[\\d+\\].*?){' + ( level - 1 ) + '}.*?)(\\[\\d+\\])' ),
			newValue = '$1' + '[' + index + ']';

		name = name.replace( regex, newValue );
		$input.attr( 'name', name );
	};

	/**
	 * When clone a group:
	 * 1) Remove sub fields' clones and keep only their first clone
	 * 2) Reset sub fields' [data-next-index] to 1
	 * 3) Set [name] for sub fields (which is done when 'clone' event is fired
	 * 4) Repeat steps 1)-3) for sub groups
	 * 5) Set the group title
	 *
	 * @param event The clone_instance custom event
	 * @param index The group clone index
	 */
	group.clone.processGroup = function ( event, index ) {
		// Do not trigger clone on parents.
		event.stopPropagation();

		var $group = $( this );

		$group
			// Add new [data-clone-group-new] to detect which group is cloned. This data is used to update sub inputs' group index
			.data( 'clone-group-new', true )
			// Remove clones, and keep only their first clone. Reset [data-next-index] to 1
			.find( '.rwmb-input' ).each( function () {
				$( this ).data( 'next-index', 1 ).children( '.rwmb-clone:gt(0)' ).remove();
			} );

		// Update [group index] for inputs
		$group.find( ':input[class|="rwmb"]' ).each( function () {
			group.clone.updateGroupIndex.call( this );
		} );

		// Update group title for the new clone.
		if ( $group.closest( '.rwmb-group-collapsible' ).length ) {
			group.toggle.updateTitle( index + 1, $group );
			group.toggle.updateState( $group );
		}
		// Sub groups: set expanded by default and reset titles.
		$group.find( '[name*="[_state]"]' ).val( 'expanded' );
		group.toggle.initTitle( $group );

		$wrapper.trigger( 'clone_completed' );
	};

	// Run when DOM ready.
	$( function() {
		$wrapper = $( '#wpbody' );

		// Add event handlers to both group title and toggle icon.
		$wrapper.on( 'click', '.rwmb-group-title, .rwmb-group-toggle-handle', group.toggle.handle );
		group.toggle.initTitle( $wrapper );

		$wrapper.on( 'clone', ':input[class|="rwmb"]', group.clone.updateIndex );
		$wrapper.on( 'clone_instance', '.rwmb-group-clone', group.clone.processGroup );
	} );
} )( jQuery, _ );
