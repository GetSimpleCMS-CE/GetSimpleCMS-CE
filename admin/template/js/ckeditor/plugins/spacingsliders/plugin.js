/**
 * Combined slider controls for adjusting line-height and letter-spacing values.
 * 
 * @license Copyright (c) 2018, Green Cat Software - Xavier Cho. All rights reserved.
 * 
 * The addon is distributed under the same license terms as the original addon 
 * which can be found here: https://ckeditor.com/cke4/addon/spacingsliders
 */
CKEDITOR.plugins.add( 'spacingsliders', {
	requires: 'panelbutton,floatpanel',
	lang: 'en,ko,uk', // %REMOVE_LINE_CORE%
	icons: 'spacingsliders', // %REMOVE_LINE_CORE%
	hidpi: false, // %REMOVE_LINE_CORE%
	init: function( editor ) {
		var config = editor.config, 
			lang = editor.lang.spacingsliders;

		var cssPath = this.path + 'skins/default.css';

		var getConfig = function( value, defaultValue) {
			return value === undefined ? defaultValue : value;
		};

		var controls = {
			lineheight: new CKEDITOR.spacingControl( 
				{
					name: 'lineheight', 
					min: getConfig( CKEDITOR.config.lineheight_min, 0 ),
					max: getConfig( CKEDITOR.config.lineheight_max, 3 ),
					step: getConfig( CKEDITOR.config.lineheight_step, 0.1 )
				},
				editor ),
			letterspacing: new CKEDITOR.spacingControl( 
				{
					name: 'letterspacing', 
					min: getConfig( CKEDITOR.config.letterspacing_min, -20 ),
					max: getConfig( CKEDITOR.config.letterspacing_max, 20 )
				},
				editor )
		};

		var styles = [];

		for ( name in controls ) {
			var control = controls[name];
			styles.push( control.createStyle() );
		}

		editor.ui.add( 'spacingsliders', CKEDITOR.UI_PANELBUTTON, {
			label: lang.title,
			title: lang.title,
			modes: {
				wysiwyg: 1
			},
			editorFocus: 0,
			toolbar: 'styles,' + 40,
			allowedContent: styles,
			panel: {
				css: CKEDITOR.skin.getPath( 'editor' ),
				attributes: {
					role: 'listbox',
					'aria-label': lang.panelTitle
				}
			},
			onBlock: function( panel, block ) {
				var document = block.element.getDocument();

				document.appendStyleSheet( cssPath );
				document.getBody().setStyle( 'overflow', 'hidden' );

				block.autoSize = true;
				block.element.addClass( 'cke_spacingblock' );

				for ( var id in controls ) {
					controls[id].render( block.element );
				}
			},
			onOpen: function() {
				var selection = editor.getSelection(),
					block = selection && selection.getStartElement(),
					path = editor.elementPath( block );

				for ( var id in controls ) {
					controls[id].update( path, block );
				}
			}
		});
	}
} );

CKEDITOR.spacingControl = CKEDITOR.tools.createClass({
	$: function( settings, editor ) {
		this.settings = settings;
		this.editor = editor;
		this.definition = editor.config[ 'spacingsliders_' + settings.name + 'Style' ];
	},
	proto: {
		createStyle: function( size ) {
			var args = size ? { size: size } : undefined;
			return new CKEDITOR.style( this.definition, args );
		},
		getValue: function() {
			if ( !this.element ) return;

			return this.input.$.value;
		},
		setValue: function( value ) {
			if ( !this.element ) return;

			this.input.$.value = value;
			this.label.setHtml( value );

			var style = this.createStyle( value );
			var path = this.editor.elementPath();

			if ( path && style.checkApplicable( path, this.editor ) ) {
				var selection = this.editor.getSelection();
				var locked = selection.isLocked;

				if ( locked ) {
					selection.unlock();
				}

				this.editor.removeStyle( new CKEDITOR.style( this.definition, { size: 'inherit' } ) );

				if ( value ) {
					this.editor.applyStyle( style );
				}

				if ( locked ) {
					selection.lock();
				}
			}
		},
		isEnabled: function () {
			return this.element && this.input.$.disabled !== true;
		},
		setEnabled: function ( value ) {
			if ( !this.element ) return;

			this.input.$.disabled = !value;

			if ( value ) {
				this.element.removeClass( 'disabled' );
			} else {
				this.element.addClass( 'disabled' );
				this.label.setHtml( '-' );
				this.input.value = 0;
			}
		},
		render: function( parent ) {
			var onChange = CKEDITOR.tools.addFunction( function ( value, saveSnapshot ) {
				this.setValue( value );

				if ( saveSnapshot ) {
					this.editor.fire( 'saveSnapshot' );
				}
			}, this );

			var lang = this.editor.lang.spacingsliders;

			var output = [];
			var value = 0;

			output.push( '<div id="' );
			output.push( this.settings.name );
			output.push( '" class="cke_spacingcontrol" title="">' );
			output.push( '<label>' );
			output.push( lang.labels[ this.settings.name ] );
			output.push( '</label>' );
			output.push( '<input type="range" ');
			output.push( ' oninput="CKEDITOR.tools.callFunction( ' );
			output.push( onChange );
			output.push( ', this.value );" ' );
			output.push( ' onchange="CKEDITOR.tools.callFunction( ' );
			output.push( onChange );
			output.push( ', this.value, true );" ' );
			output.push( 'step="' );
			output.push( this.settings.step || 1 );
			output.push( '" ' );
			output.push( 'min="' );
			output.push( this.settings.min || 0 );
			output.push( '" ' );
			output.push( 'max="' );
			output.push( this.settings.max || 100 );
			output.push( '" />' );
			output.push( '<span>' );
			output.push( value );
			output.push( '</span>' );
			output.push( '</div>' );

			parent.appendHtml( output.join( '' ) );

			this.element = parent.findOne( '#' + this.settings.name );

			this.input = parent.findOne( '#' + this.settings.name + ' input' );
			this.label = parent.findOne( '#' + this.settings.name + ' span' );
		},
		update: function( path, block ) {
			var value = path ? this.definition.getStyleValue( path, block ) : undefined;

			if ( parseFloat( value ) === value ) {
				var rounded = Math.round( value * 10 ) / 10;

				this.setEnabled( true );

				this.input.$.value = rounded;
				this.label.setHtml( rounded);
			} else {
				this.setEnabled( false );
			}
		}
	}
});

/**
 * @cfg [spacingsliders_lineheightStyle=see source]
 * @member CKEDITOR.config
 */
CKEDITOR.config.spacingsliders_lineheightStyle = {
	type: CKEDITOR.STYLE_BLOCK,
	element: 'div',
	styles: { 'line-height': '#(size)' },
	getStyleValue: function( path, block ) {
		var convert = CKEDITOR.tools.convertToPx;

		var size = convert( block.getComputedStyle( 'font-size' ) );
		var value = convert( block.getComputedStyle( 'line-height' ) );

		return size ? value / size : 0;
	}
};

/**
 * @cfg [spacingsliders_letterspacingStyle=see source]
 * @member CKEDITOR.config
 */
CKEDITOR.config.spacingsliders_letterspacingStyle = {
	element: 'div',
	styles: { 'letter-spacing': '#(size)px' },
	getStyleValue: function( path, block ) {
		var elem = path.lastElement;
		var value = elem.getComputedStyle( 'letter-spacing' );

		if ( !/^[-]?[0-9\\.]+([a-z]*)$/.test( value ) ) {
			return 0;
		}

		if ( value.startsWith( '-' )) {
			// CKEDITOR.tools.convertToPx can't calculate a negative value.
			return CKEDITOR.tools.convertToPx( value.substring( 1 ) ) * -1;
		} else {
			return CKEDITOR.tools.convertToPx( value );
		}
	}
};

/**
 * Minimum value for line height.
 * @cfg {Number} [lineheight_min=0]
 * @member CKEDITOR.config
 */

/**
 * Maximum value for line height.
 * @cfg {Number} [lineheight_max=4]
 * @member CKEDITOR.config
 */

/**
 * Interval (step) to be used for line height control.
 * @cfg {Number} [lineheight_step=0.1]
 * @member CKEDITOR.config
 */

/**
 * Minimum value for letter spacing.
 * @cfg {Number} [letterspacing_min=-20]
 * @member CKEDITOR.config
 */

/**
 * Maximum value for letter spacing.
 * @cfg {Number} [letterspacing_max=20]
 * @member CKEDITOR.config
 */

