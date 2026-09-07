/**
 * Update Customizer settings live.
 *
 * @since 1.0.0
 */
(function ($) {
	'use strict';

	// Declare variables
	var api = wp.customize,
		$body = $('body'),
		$head = $('head'),
		$style_tag,
		$link_tag,
		blogshammir_visibility_classes = 'blogshammir-hide-mobile blogshammir-hide-tablet blogshammir-hide-mobile-tablet',
		blogshammir_style_tag_collection = [],
		blogshammir_link_tag_collection = [];

	/**
	 * Helper function to get style tag with id.
	 */
	function blogshammir_get_style_tag(id) {
		if (blogshammir_style_tag_collection[id]) {
			return blogshammir_style_tag_collection[id];
		}

		$style_tag = $('head').find('#blogshammir-dynamic-' + id);

		if (!$style_tag.length) {
			$('head').append('<style id="blogshammir-dynamic-' + id + '" type="text/css" href="#"></style>');
			$style_tag = $('head').find('#blogshammir-dynamic-' + id);
		}

		blogshammir_style_tag_collection[id] = $style_tag;

		return $style_tag;
	}

	/**
	 * Helper function to get link tag with id.
	 */
	function blogshammir_get_link_tag(id, url) {
		if (blogshammir_link_tag_collection[id]) {
			return blogshammir_link_tag_collection[id];
		}

		$link_tag = $('head').find('#blogshammir-dynamic-link-' + id);

		if (!$link_tag.length) {
			$('head').append('<link id="blogshammir-dynamic-' + id + '" type="text/css" rel="stylesheet" href="' + url + '"/>');
			$link_tag = $('head').find('#blogshammir-dynamic-link-' + id);
		} else {
			$link_tag.attr('href', url);
		}

		blogshammir_link_tag_collection[id] = $link_tag;

		return $link_tag;
	}

	/*
	 * Helper function to print visibility classes.
	 */
	function blogshammir_print_visibility_classes($element, newval) {
		if (!$element.length) {
			return;
		}

		$element.removeClass(blogshammir_visibility_classes);

		if ('all' !== newval) {
			$element.addClass('blogshammir-' + newval);
		}
	}

	/*
	 * Helper function to convert hex to rgba.
	 */
	function blogshammir_hex2rgba(hex, opacity) {
		if ('rgba' === hex.substring(0, 4)) {
			return hex;
		}

		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF").
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;

		hex = hex.replace(shorthandRegex, function (m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

		if (opacity) {
			if (1 < opacity) {
				opacity = 1;
			}

			opacity = ',' + opacity;
		}

		if (result) {
			return 'rgba(' + parseInt(result[1], 16) + ',' + parseInt(result[2], 16) + ',' + parseInt(result[3], 16) + opacity + ')';
		}

		return false;
	}

	/**
	 * Helper function to lighten or darken the provided hex color.
	 */
	function blogshammir_luminance(hex, percent) {

		// Convert RGB color to HEX.
		if (hex.includes('rgb')) {
			hex = blogshammir_rgba2hex(hex);
		}

		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF").
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;

		hex = hex.replace(shorthandRegex, function (m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

		var isColor = /^#[0-9A-F]{6}$/i.test(hex);

		if (!isColor) {
			return hex;
		}

		var from, to;

		for (var i = 1; 3 >= i; i++) {
			result[i] = parseInt(result[i], 16);
			from = 0 > percent ? 0 : result[i];
			to = 0 > percent ? result[i] : 255;
			result[i] = result[i] + Math.ceil((to - from) * percent);
		}

		result = '#' + blogshammir_dec2hex(result[1]) + blogshammir_dec2hex(result[2]) + blogshammir_dec2hex(result[3]);

		return result;
	}

	/**
	 * Convert dec to hex.
	 */
	function blogshammir_dec2hex(c) {
		var hex = c.toString(16);
		return 1 == hex.length ? '0' + hex : hex;
	}

	/**
	 * Convert rgb to hex.
	 */
	function blogshammir_rgba2hex(c) {
		var a, x;

		a = c.split('(')[1].split(')')[0].trim();
		a = a.split(',');

		var result = '';

		for (var i = 0; 3 > i; i++) {
			x = parseInt(a[i]).toString(16);
			result += 1 === x.length ? '0' + x : x;
		}

		if (result) {
			return '#' + result;
		}

		return false;
	}

	/**
	 * Check if is light color.
	 */
	function blogshammir_is_light_color(color = '') {
		var r, g, b, brightness;

		if (color.match(/^rgb/)) {
			color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);
			r = color[1];
			g = color[2];
			b = color[3];
		} else {
			color = +('0x' + color.slice(1).replace(5 > color.length && /./g, '$&$&'));
			r = color >> 16;
			g = (color >> 8) & 255;
			b = color & 255;
		}

		brightness = (r * 299 + g * 587 + b * 114) / 1000;

		return 137 < brightness;
	}

	/**
	 * Detect if we should use a light or dark color on a background color.
	 */
	function blogshammir_light_or_dark(color, dark = '#000000', light = '#FFFFFF') {
		return blogshammir_is_light_color(color) ? dark : light;
	}

	/**
	 * Spacing field CSS.
	 */
	function blogshammir_spacing_field_css(selector, property, setting, responsive) {
		if (!Array.isArray(setting) && 'object' !== typeof setting) {
			return;
		}

		// Set up unit.
		var unit = 'px',
			css = '';

		if ('unit' in setting) {
			unit = setting.unit;
		}

		var before = '',
			after = '';

		Object.keys(setting).forEach(function (index, el) {
			if ('unit' === index) {
				return;
			}

			if (responsive) {
				if ('tablet' === index) {
					before = '@media only screen and (max-width: 768px) {';
					after = '}';
				} else if ('mobile' === index) {
					before = '@media only screen and (max-width: 480px) {';
					after = '}';
				} else {
					before = '';
					after = '';
				}

				css += before + selector + '{';

				Object.keys(setting[index]).forEach(function (position) {
					if ('border' === property) {
						position += '-width';
					}

					if (setting[index][position]) {
						css += property + '-' + position + ': ' + setting[index][position] + unit + ';';
					}
				});

				css += '}' + after;
			} else {
				if ('border' === property) {
					index += '-width';
				}

				css += property + '-' + index + ': ' + setting[index] + unit + ';';
			}
		});

		if (!responsive) {
			css = selector + '{' + css + '}';
		}

		return css;
	}

	/**
	 * Range field CSS.
	 */
	function blogshammir_range_field_css(selector, property, setting, responsive, unit) {
		var css = '',
			before = '',
			after = '';

		if (responsive && (Array.isArray(setting) || 'object' === typeof setting)) {
			Object.keys(setting).forEach(function (index, el) {
				if (setting[index]) {
					if ('tablet' === index) {
						before = '@media only screen and (max-width: 768px) {';
						after = '}';
					} else if ('mobile' === index) {
						before = '@media only screen and (max-width: 480px) {';
						after = '}';
					} else if ('desktop' === index) {
						before = '';
						after = '';
					} else {
						return;
					}

					css += before + selector + '{' + property + ': ' + setting[index] + unit + '; }' + after;
				}
			});
		}

		if (!responsive) {
			if (setting.value) {
				setting = setting.value;
			} else {
				setting = 0;
			}

			css = selector + '{' + property + ': ' + setting + unit + '; }';
		}

		return css;
	}

	/**
	 * Typography field CSS.
	 */
	function blogshammir_typography_field_css(selector, setting) {
		var css = '';

		css += selector + '{';

		if ('default' === setting['font-family']) {
			css += 'font-family: ' + blogshammir_customizer_preview.default_system_font + ';';
		} else if (setting['font-family'] in blogshammir_customizer_preview.fonts.standard_fonts.fonts) {
			css += 'font-family: ' + blogshammir_customizer_preview.fonts.standard_fonts.fonts[setting['font-family']].fallback + ';';
		} else if ('inherit' !== setting['font-family']) {
			css += 'font-family: "' + setting['font-family'] + '";';
		}

		css += 'font-weight:' + setting['font-weight'] + ';';
		css += 'font-style:' + setting['font-style'] + ';';
		css += 'text-transform:' + setting['text-transform'] + ';';

		if ('text-decoration' in setting) {
			css += 'text-decoration:' + setting['text-decoration'] + ';';
		}

		if ('letter-spacing' in setting) {
			css += 'letter-spacing:' + setting['letter-spacing'] + setting['letter-spacing-unit'] + ';';
		}

		if ('line-height-desktop' in setting) {
			css += 'line-height:' + setting['line-height-desktop'] + ';';
		}

		if ('font-size-desktop' in setting && 'font-size-unit' in setting) {
			css += 'font-size:' + setting['font-size-desktop'] + setting['font-size-unit'] + ';';
		}

		css += '}';

		if ('font-size-tablet' in setting && setting['font-size-tablet']) {
			css += '@media only screen and (max-width: 768px) {' + selector + '{' + 'font-size: ' + setting['font-size-tablet'] + setting['font-size-unit'] + ';' + '}' + '}';
		}

		if ('line-height-tablet' in setting && setting['line-height-tablet']) {
			css += '@media only screen and (max-width: 768px) {' + selector + '{' + 'line-height:' + setting['line-height-tablet'] + ';' + '}' + '}';
		}

		if ('font-size-mobile' in setting && setting['font-size-mobile']) {
			css += '@media only screen and (max-width: 480px) {' + selector + '{' + 'font-size: ' + setting['font-size-mobile'] + setting['font-size-unit'] + ';' + '}' + '}';
		}

		if ('line-height-mobile' in setting && setting['line-height-mobile']) {
			css += '@media only screen and (max-width: 480px) {' + selector + '{' + 'line-height:' + setting['line-height-mobile'] + ';' + '}' + '}';
		}

		return css;
	}

	/**
	 * Load google font.
	 */
	function blogshammir_enqueue_google_font(font) {
		if (blogshammir_customizer_preview.fonts.google_fonts.fonts[font]) {
			var id = 'google-font-' + font.trim().toLowerCase().replace(' ', '-');
			var url = blogshammir_customizer_preview.google_fonts_url + '/css?family=' + font + ':' + blogshammir_customizer_preview.google_font_weights;

			var tag = blogshammir_get_link_tag(id, url);
		}
	}

	/**
	 * Design Options field CSS.
	 */
	function blogshammir_design_options_css(selector, setting, type) {
		var css = '',
			before = '',
			after = '';

		if ('background' === type) {
			var bg_type = setting['background-type'];

			css += selector + '{';

			if ('color' === bg_type) {
				setting['background-color'] = setting['background-color'] ? setting['background-color'] : 'inherit';
				css += 'background: ' + setting['background-color'] + ';';
			} else if ('gradient' === bg_type) {
				css += 'background: ' + setting['gradient-color-1'] + ';';

				if ('linear' === setting['gradient-type']) {
					css +=
						'background: -webkit-linear-gradient(' +
						setting['gradient-linear-angle'] +
						'deg, ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);' +
						'background: -o-linear-gradient(' +
						setting['gradient-linear-angle'] +
						'deg, ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);' +
						'background: linear-gradient(' +
						setting['gradient-linear-angle'] +
						'deg, ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);';
				} else if ('radial' === setting['gradient-type']) {
					css +=
						'background: -webkit-radial-gradient(' +
						setting['gradient-position'] +
						', circle, ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);' +
						'background: -o-radial-gradient(' +
						setting['gradient-position'] +
						', circle, ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);' +
						'background: radial-gradient(circle at ' +
						setting['gradient-position'] +
						', ' +
						setting['gradient-color-1'] +
						' ' +
						setting['gradient-color-1-location'] +
						'%, ' +
						setting['gradient-color-2'] +
						' ' +
						setting['gradient-color-2-location'] +
						'%);';
				}
			} else if ('image' === bg_type) {
				css +=
					'' +
					'background-image: url(' +
					setting['background-image'] +
					');' +
					'background-size: ' +
					setting['background-size'] +
					';' +
					'background-attachment: ' +
					setting['background-attachment'] +
					';' +
					'background-position: ' +
					setting['background-position-x'] +
					'% ' +
					setting['background-position-y'] +
					'%;' +
					'background-repeat: ' +
					setting['background-repeat'] +
					';';
			}

			css += '}';

			// Background image color overlay.
			if ('image' === bg_type && setting['background-color-overlay'] && setting['background-image']) {
				css += selector + '::after { background-color: ' + setting['background-color-overlay'] + '; }';
			} else {
				css += selector + '::after { background-color: initial; }';
			}
		} else if ('color' === type) {
			setting['text-color'] = setting['text-color'] ? setting['text-color'] : 'inherit';
			setting['link-color'] = setting['link-color'] ? setting['link-color'] : 'inherit';
			setting['link-hover-color'] = setting['link-hover-color'] ? setting['link-hover-color'] : 'inherit';

			css += selector + ' { color: ' + setting['text-color'] + '; }';
			css += selector + ' a { color: ' + setting['link-color'] + '; }';
			css += selector + ' a:hover { color: ' + setting['link-hover-color'] + ' !important; }';
		} else if ('border' === type) {
			setting['border-color'] = setting['border-color'] ? setting['border-color'] : 'inherit';
			setting['border-style'] = setting['border-style'] ? setting['border-style'] : 'solid';
			setting['border-left-width'] = setting['border-left-width'] ? setting['border-left-width'] : 0;
			setting['border-top-width'] = setting['border-top-width'] ? setting['border-top-width'] : 0;
			setting['border-right-width'] = setting['border-right-width'] ? setting['border-right-width'] : 0;
			setting['border-bottom-width'] = setting['border-bottom-width'] ? setting['border-bottom-width'] : 0;

			css += selector + '{';
			css += 'border-color: ' + setting['border-color'] + ';';
			css += 'border-style: ' + setting['border-style'] + ';';
			css += 'border-left-width: ' + setting['border-left-width'] + 'px;';
			css += 'border-top-width: ' + setting['border-top-width'] + 'px;';
			css += 'border-right-width: ' + setting['border-right-width'] + 'px;';
			css += 'border-bottom-width: ' + setting['border-bottom-width'] + 'px;';
			css += '}';
		} else if ('separator_color' === type) {
			css += selector + ':after{ background-color: ' + setting['separator-color'] + '; }';
		}

		return css;
	}

	/**
	 * Logo max height.
	 */
	api('blogshammir_logo_max_height', function (value) {
		value.bind(function (newval) {
			var $logo = $('.blogshammir-logo');

			if (!$logo.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_logo_max_height');
			var style_css = '';

			style_css += blogshammir_range_field_css('.blogshammir-logo img', 'max-height', newval, true, 'px');
			style_css += blogshammir_range_field_css('.blogshammir-logo img.blogshammir-svg-logo', 'height', newval, true, 'px');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Logo text font size.
	 */
	api('blogshammir_logo_text_font_size', function (value) {
		value.bind(function (newval) {
			var $logo = $('#blogshammir-header .blogshammir-logo .site-title');

			if (!$logo.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_logo_text_font_size');
			var style_css = '';

			style_css += blogshammir_range_field_css('#blogshammir-header .blogshammir-logo .site-title', 'font-size', newval, true, newval.unit);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Logo margin.
	 */
	api('blogshammir_logo_margin', function (value) {
		value.bind(function (newval) {
			var $logo = $('.blogshammir-logo');

			if (!$logo.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_logo_margin');

			var style_css = blogshammir_spacing_field_css('.blogshammir-logo .logo-inner', 'margin', newval, true);
			$style_tag.html(style_css);
		});
	});

	/**
	 * Tagline.
	 */
	api('blogdescription', function (value) {
		value.bind(function (newval) {
			if ($('.blogshammir-logo').find('.site-description').length) {
				$('.blogshammir-logo').find('.site-description').html(newval);
			}
		});
	});

	/**
	 * Site Title.
	 */
	api('blogname', function (value) {
		value.bind(function (newval) {
			if ($('.blogshammir-logo').find('.site-title').length) {
				$('.blogshammir-logo').find('.site-title').find('a').html(newval);
			}
		});
	});

	/**
	 * Site Layout.
	 */
	api('blogshammir_site_layout', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-layout__(?!boxed-separated)\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-layout__' + newval);
		});
	});

	/**
	 * Sticky Sidebar.
	 */
	api('blogshammir_sidebar_sticky', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-sticky-\S+/g) || []).join(' ');
			});

			if (newval) {
				$body.addClass('blogshammir-sticky-' + newval);
			}
		});
	});

	/**
	 * Sidebar width.
	 */
	api('blogshammir_sidebar_width', function (value) {
		value.bind(function (newval) {
			var $sidebar = $('#secondary');

			if (!$sidebar.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_sidebar_width');
			var style_css = '#secondary { width: ' + newval.value + '%; }';
			style_css += 'body:not(.blogshammir-no-sidebar) #primary { ' + 'max-width: ' + (100 - parseInt(newval.value)) + '%;' + '};';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Single Page title spacing.
	 */
	api('blogshammir_single_title_spacing', function (value) {
		value.bind(function (newval) {
			var $page_header = $('.page-header');

			if (!$page_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_single_title_spacing');

			var style_css = blogshammir_spacing_field_css('.blogshammir-single-title-in-page-header #page .page-header .blogshammir-page-header-wrapper', 'padding', newval, true);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Single post narrow container width.
	 */
	api('blogshammir_single_narrow_container_width', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_single_narrow_container_width');
			var style_css = '';

			style_css +=
				'.single-post.narrow-content .entry-content > :not([class*="align"]):not([class*="gallery"]):not(.wp-block-image):not(.quote-inner):not(.quote-post-bg), ' +
				'.single-post.narrow-content .mce-content-body:not([class*="page-template-full-width"]) > :not([class*="align"]):not([data-wpview-type*="gallery"]):not(blockquote):not(.mceTemp), ' +
				'.single-post.narrow-content .entry-footer, ' +
				'.single-post.narrow-content .post-nav, ' +
				'.single-post.narrow-content .entry-content > .alignwide, ' +
				'.single-post.narrow-content p.has-background:not(.alignfull):not(.alignwide)' +
				'.single-post.narrow-content #blogshammir-comments-toggle, ' +
				'.single-post.narrow-content #comments, ' +
				'.single-post.narrow-content .entry-content .aligncenter, ' +
				'.single-post.narrow-content .blogshammir-narrow-element, ' +
				'.single-post.narrow-content.blogshammir-single-title-in-content .entry-header, ' +
				'.single-post.narrow-content.blogshammir-single-title-in-content .entry-meta, ' +
				'.single-post.narrow-content.blogshammir-single-title-in-content .post-category, ' +
				'.single-post.narrow-content.blogshammir-no-sidebar .blogshammir-page-header-wrapper, ' +
				'.single-post.narrow-content.blogshammir-no-sidebar .blogshammir-breadcrumbs > .blogshammir-container > nav {' +
				'max-width: ' +
				parseInt(newval.value) +
				'px; margin-left: auto; margin-right: auto; ' +
				'}';

			style_css += '.single-post.narrow-content .author-box, ' + '.single-post.narrow-content .entry-content > .alignwide { ' + 'max-width: ' + (parseInt(newval.value) + 70) + 'px;' + '}';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Single post content font size.
	 */
	api('blogshammir_single_content_font_size', function (value) {
		value.bind(function (newval) {
			var $content = $('.single-post');

			if (!$content.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_single_content_font_size');
			var style_css = '';

			style_css += blogshammir_range_field_css('.single-post .entry-content', 'font-size', newval, true, newval.unit);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Header container width.
	 */
	api('blogshammir_header_container_width', function (value) {
		value.bind(function (newval) {
			var $header = $('#blogshammir-header');

			if (!$header.length) {
				return;
			}

			if ('full-width' === newval) {
				$header.addClass('blogshammir-container__wide');
			} else {
				$header.removeClass('blogshammir-container__wide');
			}
		});
	});

	/**
	 * Main navigation disply breakpoint.
	 */
	api('blogshammir_main_nav_mobile_breakpoint', function (value) {
		value.bind(function (newval) {
			var $nav = $('#blogshammir-header-inner .blogshammir-nav');

			if (!$nav.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_main_nav_mobile_breakpoint');
			var style_css = '';

			style_css += '@media screen and (min-width: ' + parseInt(newval) + 'px) {#blogshammir-header-inner .blogshammir-nav {display:flex} .blogshammir-mobile-nav,.blogshammir-mobile-toggen,#blogshammir-header-inner .blogshammir-nav .menu-item-has-children>a > .blogshammir-icon,#blogshammir-header-inner .blogshammir-nav .page_item_has_children>a > .blogshammir-icon {display:none;} }';
			style_css += '@media screen and (max-width: ' + parseInt(newval) + 'px) {#blogshammir-header-inner .blogshammir-nav {display:none} .blogshammir-mobile-nav,.blogshammir-mobile-toggen {display:inline-flex;} }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Mobile Menu Button Label.
	 */
	api('blogshammir_main_nav_mobile_label', function (value) {
		value.bind(function (newval) {
			if ($('.blogshammir-hamburger-blogshammir-primary-nav').find('.hamburger-label').length) {
				$('.blogshammir-hamburger-blogshammir-primary-nav').find('.hamburger-label').html(newval);
			}
		});
	});

	/**
	 * Main Nav Font color.
	 */
	api('blogshammir_main_nav_font_color', function (value) {
		value.bind(function (newval) {
			var $navigation = $('#blogshammir-header-inner .blogshammir-nav');

			if (!$navigation.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_main_nav_font_color');
			var style_css = '';

			// Link color.
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			style_css += '#blogshammir-header-inner .blogshammir-nav > ul > li > a { color: ' + newval['link-color'] + '; }';

			// Link hover color.
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : api.value('blogshammir_accent_color')();
			style_css +=
				'#blogshammir-header-inner .blogshammir-nav > ul > li > a:hover, ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.menu-item-has-children:hover > a, ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-item > a, ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-ancestor > a ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.page_item_has_children:hover > a, ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.current_page_item > a, ' +
				'#blogshammir-header-inner .blogshammir-nav > ul > li.current_page_ancestor > a ' +
				'{ color: ' +
				newval['link-hover-color'] +
				'; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Main Nav Background.
	 */
	api('blogshammir_main_nav_background', function (value) {
		value.bind(function (newval) {
			var $navigation = $('.blogshammir-header-layout-6 .blogshammir-nav-container, .blogshammir-header-layout-4 .blogshammir-nav-container, .blogshammir-header-layout-3 .blogshammir-nav-container');

			if (!$navigation.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_main_nav_background');
			var style_css = blogshammir_design_options_css('.blogshammir-header-layout-3 .blogshammir-nav-container', newval, 'background');
			style_css += blogshammir_design_options_css('.blogshammir-header-layout-4 .blogshammir-nav-container', newval, 'background');
			style_css += blogshammir_design_options_css('.blogshammir-header-layout-6 .blogshammir-nav-container', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Main Nav Border.
	 */
	api('blogshammir_main_nav_border', function (value) {
		value.bind(function (newval) {
			var $navigation = $('.blogshammir-header-layout-6 .blogshammir-nav-container, .blogshammir-header-layout-4 .blogshammir-nav-container, .blogshammir-header-layout-3 .blogshammir-nav-container');

			if (!$navigation.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_main_nav_border');
			var style_css = blogshammir_design_options_css('.blogshammir-header-layout-3 .blogshammir-nav-container', newval, 'border');
			style_css += blogshammir_design_options_css('.blogshammir-header-layout-4 .blogshammir-nav-container', newval, 'border');
			style_css += blogshammir_design_options_css('.blogshammir-header-layout-6 .blogshammir-nav-container', newval, 'border');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Main Nav font size.
	 */
	api('blogshammir_main_nav_font', function (value) {
		value.bind(function (newval) {
			var $nav = $('#blogshammir-header-inner');

			if (!$nav.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_main_nav_font');
			var style_css = blogshammir_typography_field_css('.blogshammir-nav.blogshammir-header-element, .blogshammir-header-layout-1 .blogshammir-header-widgets, .blogshammir-header-layout-2 .blogshammir-header-widgets', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Top Bar container width.
	 */
	api('blogshammir_top_bar_container_width', function (value) {
		value.bind(function (newval) {
			var $topbar = $('#blogshammir-topbar');

			if (!$topbar.length) {
				return;
			}

			if ('full-width' === newval) {
				$topbar.addClass('blogshammir-container__wide');
			} else {
				$topbar.removeClass('blogshammir-container__wide');
			}
		});
	});

	/**
	 * Top Bar visibility.
	 */
	api('blogshammir_top_bar_visibility', function (value) {
		value.bind(function (newval) {
			var $topbar = $('#blogshammir-topbar');

			blogshammir_print_visibility_classes($topbar, newval);
		});
	});

	/**
	 * Top Bar widgets separator.
	 */
	api('blogshammir_top_bar_widgets_separator', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-topbar__separators-\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-topbar__separators-' + newval);
		});
	});

	/**
	 * Top Bar background.
	 */
	api('blogshammir_top_bar_background', function (value) {
		value.bind(function (newval) {
			var $topbar = $('#blogshammir-topbar');

			if (!$topbar.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_top_bar_background');
			var style_css = blogshammir_design_options_css('#blogshammir-topbar', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Top Bar color.
	 */
	api('blogshammir_top_bar_text_color', function (value) {
		value.bind(function (newval) {
			var $topbar = $('#blogshammir-topbar');

			if (!$topbar.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_top_bar_text_color');
			var style_css = '';

			newval['text-color'] = newval['text-color'] ? newval['text-color'] : 'inherit';
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : 'inherit';

			// Text color.
			style_css += '#blogshammir-topbar { color: ' + newval['text-color'] + '; }';

			// Link color.
			style_css += '.blogshammir-topbar-widget__text a, ' + '.blogshammir-topbar-widget .blogshammir-nav > ul > li > a, ' + '.blogshammir-topbar-widget__socials .blogshammir-social-nav > ul > li > a, ' + '#blogshammir-topbar .blogshammir-topbar-widget__text .blogshammir-icon { color: ' + newval['link-color'] + '; }';

			// Link hover color.
			style_css +=
				'#blogshammir-topbar .blogshammir-nav > ul > li > a:hover, ' +
				'.using-keyboard #blogshammir-topbar .blogshammir-nav > ul > li > a:focus, ' +
				'#blogshammir-topbar .blogshammir-nav > ul > li.menu-item-has-children:hover > a,  ' +
				'#blogshammir-topbar .blogshammir-nav > ul > li.current-menu-item > a, ' +
				'#blogshammir-topbar .blogshammir-nav > ul > li.current-menu-ancestor > a, ' +
				'#blogshammir-topbar .blogshammir-topbar-widget__text a:hover, ' +
				'#blogshammir-topbar .blogshammir-social-nav > ul > li > a .blogshammir-icon.bottom-icon { color: ' +
				newval['link-hover-color'] +
				'; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Top Bar border.
	 */
	api('blogshammir_top_bar_border', function (value) {
		value.bind(function (newval) {
			var $topbar = $('#blogshammir-topbar');

			if (!$topbar.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_top_bar_border');
			var style_css = blogshammir_design_options_css('#blogshammir-topbar', newval, 'border');

			style_css += blogshammir_design_options_css('#blogshammir-topbar .blogshammir-topbar-widget', newval, 'separator_color');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Header menu item hover animation.
	 */
	api('blogshammir_main_nav_hover_animation', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-menu-animation-\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-menu-animation-' + newval);
		});
	});

	/**
	 * Header widgets separator.
	 */
	api('blogshammir_header_widgets_separator', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-header__separators-\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-header__separators-' + newval);
		});
	});

	/**
	 * Header background.
	 */
	api('blogshammir_header_background', function (value) {
		value.bind(function (newval) {
			var $header = $('#blogshammir-header-inner');

			if (!$header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_header_background');
			var style_css = blogshammir_design_options_css('#blogshammir-header-inner', newval, 'background');

			if ('color' === newval['background-type'] && newval['background-color']) {
				style_css += '.blogshammir-header-widget__cart .blogshammir-cart .blogshammir-cart-count { border: 2px solid ' + newval['background-color'] + '; }';
			} else {
				style_css += '.blogshammir-header-widget__cart .blogshammir-cart .blogshammir-cart-count { border: none; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Header font color.
	 */
	api('blogshammir_header_text_color', function (value) {
		value.bind(function (newval) {
			var $header = $('#blogshammir-header');

			if (!$header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_header_text_color');
			var style_css = '';

			// Text color.
			style_css += '.blogshammir-logo .site-description { color: ' + newval['text-color'] + '; }';

			// Link color.
			if (newval['link-color']) {
				style_css += '#blogshammir-header, ' + '.blogshammir-header-widgets a:not(.blogshammir-btn), ' + '.blogshammir-logo a,' + '.blogshammir-hamburger { color: ' + newval['link-color'] + '; }';
				style_css += '.hamburger-inner,' + '.hamburger-inner::before,' + '.hamburger-inner::after { background-color: ' + newval['link-color'] + '; }';
			}

			// Link hover color.
			if (newval['link-hover-color']) {
				style_css +=
					'.blogshammir-header-widgets a:not(.blogshammir-btn):hover, ' +
					'#blogshammir-header-inner .blogshammir-header-widgets .blogshammir-active,' +
					'.blogshammir-logo .site-title a:hover, ' +
					'.blogshammir-hamburger:hover .hamburger-label, ' +
					'.is-mobile-menu-active .blogshammir-hamburger .hamburger-label,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li > a:hover,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.menu-item-has-children:hover > a,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-item > a,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-ancestor > a,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.page_item_has_children:hover > a,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.current_page_item > a,' +
					'#blogshammir-header-inner .blogshammir-nav > ul > li.current_page_ancestor > a { color: ' +
					newval['link-hover-color'] +
					'; }';

				style_css +=
					'.blogshammir-hamburger:hover .hamburger-inner,' +
					'.blogshammir-hamburger:hover .hamburger-inner::before,' +
					'.blogshammir-hamburger:hover .hamburger-inner::after,' +
					'.is-mobile-menu-active .blogshammir-hamburger .hamburger-inner,' +
					'.is-mobile-menu-active .blogshammir-hamburger .hamburger-inner::before,' +
					'.is-mobile-menu-active .blogshammir-hamburger .hamburger-inner::after { background-color: ' +
					newval['link-hover-color'] +
					'; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Header border.
	 */
	api('blogshammir_header_border', function (value) {
		value.bind(function (newval) {
			var $header = $('#blogshammir-header-inner');

			if (!$header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_header_border');
			var style_css = blogshammir_design_options_css('#blogshammir-header-inner', newval, 'border');

			// Separator color.
			newval['separator-color'] = newval['separator-color'] ? newval['separator-color'] : 'inherit';
			style_css += '.blogshammir-header-widget:after { background-color: ' + newval['separator-color'] + '; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Featured Links title.
	 */
	api('blogshammir_featured_links_title', function (value) {
		value.bind(function (newval) {
			$('#featured_links .widget-title').text(newval);
		});
	});

	/**
	 * PYML title.
	 */
	api('blogshammir_pyml_title', function (value) {
		value.bind(function (newval) {
			$('#pyml .widget-title').text(newval);
		});
	});

	/**
	 * Related posts title.
	 */
	api('blogshammir_related_posts_heading', function (value) {
		value.bind(function (newval) {
			$('#related_posts .widget-title').text(newval);
		});
	});

	/**
	 * Ticker News title.
	 */
	api('blogshammir_ticker_title', function (value) {
		value.bind(function (newval) {
			$('#ticker .ticker-title .title').text(newval);
		});
	});

	/**
	 * Custom input style.
	 */
	api('blogshammir_custom_input_style', function (value) {
		value.bind(function (newval) {
			if (newval) {
				$body.addClass('blogshammir-input-supported');
			} else {
				$body.removeClass('blogshammir-input-supported');
			}
		});
	});

	/**
	 * WooCommerce sale badge text.
	 */
	api('blogshammir_product_sale_badge_text', function (value) {
		value.bind(function (newval) {
			var $badge = $('.woocommerce ul.products li.product .onsale, .woocommerce span.onsale').not('.sold-out');

			if (!$badge.length) {
				return;
			}

			$badge.html(newval);
		});
	});

	/**
	 * Accent color.
	 */
	api('blogshammir_accent_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_accent_color');
			var style_css;

			// Colors.
			style_css =
				':root { ' +
				'--blogshammir-primary: ' + newval + ';' +
				'--blogshammir-primary_80: ' + blogshammir_luminance(newval, 0.80) + ';' +
				'--blogshammir-primary_15: ' + blogshammir_luminance(newval, 0.15) + ';' +
				'--blogshammir-primary_27: ' + blogshammir_hex2rgba(newval, 0.27) + ';' +
				'--blogshammir-primary_10: ' + blogshammir_hex2rgba(newval, 0.10) + ';' +
				'}';

			$style_tag.html(style_css);
		});
	});

	api('blogshammir_dark_mode', function (value) {
		value.bind(function (newval) {
			if (newval) {
				document.documentElement.setAttribute('data-darkmode', 'dark');
				localStorage.setItem('darkmode', 'dark');
			} else {
				document.documentElement.setAttribute('data-darkmode', 'light');
				localStorage.setItem('darkmode', 'light');
			}
		})
	});

	/**
	 * Content background color.
	 */
	api('blogshammir_boxed_content_background_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_boxed_content_background_color');
			var style_css = '';

			if (newval) {
				style_css =
					'.blogshammir-layout__boxed .blogshammir-card-items .blogshammir-swiper-buttons, ' +
					'.blogshammir-card__boxed .blogshammir-card-items, ' +
					'.blogshammir-layout__boxed-separated.author .author-box, ' +
					'.blogshammir-layout__boxed-separated #comments, ' +
					'.blogshammir-layout__boxed-separated #content > article, ' +
					'.blogshammir-layout__boxed-separated.blogshammir-sidebar-style-2 #secondary .blogshammir-widget, ' +
					'.blogshammir-layout__boxed-separated.blogshammir-sidebar-style-2 .elementor-widget-sidebar .blogshammir-widget, ' +
					'.blogshammir-layout__boxed-separated.page .blogshammir-article,' +
					'.blogshammir-layout__boxed-separated.archive .blogshammir-article,' +
					'.blogshammir-layout__boxed-separated.blog .blogshammir-article, ' +
					'.blogshammir-layout__boxed-separated.search-results .blogshammir-article, ' +
					'.blogshammir-layout__boxed-separated.category .blogshammir-article { background-color: ' +
					newval +
					'; }';

				// style_css += '@media screen and (max-width: 960px) { ' + '.blogshammir-layout__boxed-separated #page { background-color: ' + newval + '; }' + '}';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Content text color.
	 */
	api('blogshammir_content_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_content_text_color');
			var style_css = '';

			if (newval) {
				style_css =
					'body { ' +
					'color: ' +
					newval +
					';' +
					'}' +
					'.comment-form .comment-notes, ' +
					'#comments .no-comments, ' +
					'#page .wp-caption .wp-caption-text,' +
					'#comments .comment-meta,' +
					'.comments-closed,' +
					'.blogshammir-entry cite,' +
					'legend,' +
					'.blogshammir-page-header-description,' +
					'.page-links em,' +
					'.site-content .page-links em,' +
					'.single .entry-footer .last-updated,' +
					'.single .post-nav .post-nav-title,' +
					'#main .widget_recent_comments span,' +
					'#main .widget_recent_entries span,' +
					'#main .widget_calendar table > caption,' +
					'.post-thumb-caption, ' +
					'.wp-block-image figcaption, ' +
					'.blogshammir-cart-item .blogshammir-x,' +
					'.woocommerce form.login .lost_password a,' +
					'.woocommerce form.register .lost_password a,' +
					'.woocommerce a.remove,' +
					'#add_payment_method .cart-collaterals .cart_totals .woocommerce-shipping-destination, ' +
					'.woocommerce-cart .cart-collaterals .cart_totals .woocommerce-shipping-destination, ' +
					'.woocommerce-checkout .cart-collaterals .cart_totals .woocommerce-shipping-destination,' +
					'.woocommerce ul.products li.product .blogshammir-loop-product__category-wrap a,' +
					'.woocommerce ul.products li.product .blogshammir-loop-product__category-wrap,' +
					'.woocommerce .woocommerce-checkout-review-order table.shop_table thead th,' +
					'#add_payment_method #payment div.payment_box, ' +
					'.woocommerce-cart #payment div.payment_box, ' +
					'.woocommerce-checkout #payment div.payment_box,' +
					'#add_payment_method #payment ul.payment_methods .about_paypal, ' +
					'.woocommerce-cart #payment ul.payment_methods .about_paypal, ' +
					'.woocommerce-checkout #payment ul.payment_methods .about_paypal,' +
					'.woocommerce table dl,' +
					'.woocommerce table .wc-item-meta,' +
					'.widget.woocommerce .reviewer,' +
					'.woocommerce.widget_shopping_cart .cart_list li a.remove:before,' +
					'.woocommerce .widget_shopping_cart .cart_list li a.remove:before,' +
					'.woocommerce .widget_shopping_cart .cart_list li .quantity, ' +
					'.woocommerce.widget_shopping_cart .cart_list li .quantity,' +
					'.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link,' +
					'.woocommerce div.product .woocommerce-tabs table.shop_attributes td,' +
					'.woocommerce div.product .product_meta > span span:not(.blogshammir-woo-meta-title), ' +
					'.woocommerce div.product .product_meta > span a,' +
					'.woocommerce .star-rating::before,' +
					'.woocommerce div.product #reviews #comments ol.commentlist li .comment-text p.meta,' +
					'.ywar_review_count,' +
					'.woocommerce .add_to_cart_inline del, ' +
					'.woocommerce div.product p.price del, ' +
					'.woocommerce div.product span.price del { color: ' +
					blogshammir_hex2rgba(newval, 0.75) +
					'; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Content link hover color.
	 */
	api('blogshammir_content_link_hover_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_content_link_hover_color');
			var style_css = '';

			if (newval) {

				// Content link hover.
				style_css +=
					'.content-area a:not(.blogshammir-btn, .wp-block-button__link, [class^="cat-"], [rel="tag"]):hover, ' +
					'.blogshammir-woo-before-shop select.custom-select-loaded:hover ~ #blogshammir-orderby, ' +
					'#add_payment_method #payment ul.payment_methods .about_paypal:hover, ' +
					'.woocommerce-cart #payment ul.payment_methods .about_paypal:hover, ' +
					'.woocommerce-checkout #payment ul.payment_methods .about_paypal:hover, ' +
					'.blogshammir-breadcrumbs a:hover, ' +
					'.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link:hover, ' +
					'.woocommerce ul.products li.product .meta-wrap .woocommerce-loop-product__link:hover, ' +
					'.woocommerce ul.products li.product .blogshammir-loop-product__category-wrap a:hover { ' +
					'color: ' +
					newval +
					';' +
					'}';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Content text color.
	 */
	api('blogshammir_headings_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_headings_color');
			var style_css = '';

			if (newval) {
				style_css = 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, a, .entry-meta, .blogshammir-logo .site-title, .wp-block-heading, .wp-block-search__label, .error-404 .page-header h1 { ' + 'color: ' + newval + ';' + '} :root { ' + '--blogshammir-secondary: ' + newval + ';' + '}';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Scroll Top visibility.
	 */
	api('blogshammir_scroll_top_visibility', function (value) {
		value.bind(function (newval) {
			blogshammir_print_visibility_classes($('#blogshammir-scroll-top'), newval);
		});
	});

	/**
	 * Page Preloader visibility.
	 */
	api('blogshammir_preloader_visibility', function (value) {
		value.bind(function (newval) {
			blogshammir_print_visibility_classes($('#blogshammir-preloader'), newval);
		});
	});

	/**
	 * Footer visibility.
	 */
	api('blogshammir_footer_visibility', function (value) {
		value.bind(function (newval) {
			blogshammir_print_visibility_classes($('#blogshammir-footer'), newval);
		});
	});

	/**
	 * Footer Widget Heading Style Enable.
	 */
	api('blogshammir_footer_widget_heading_style', function (value) {
		value.bind(function (newval) {
			$body
				.removeClass(function (index, className) {
					return (className.match(/(^|\s)is-footer-heading-init-s\S+/g) || []).join(' ');
				})
				.addClass('is-footer-heading-init-s' + api.value('blogshammir_footer_widget_heading_style')());
		});
	});

	/**
	 * Footer background.
	 */
	api('blogshammir_footer_background', function (value) {
		value.bind(function (newval) {
			var $footer = $('#colophon');

			if (!$footer.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_footer_background');
			var style_css = blogshammir_design_options_css('#colophon', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Footer font color.
	 */
	api('blogshammir_footer_text_color', function (value) {
		var $footer = $('#blogshammir-footer'),
			copyright_separator_color,
			style_css;

		value.bind(function (newval) {
			if (!$footer.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_footer_text_color');

			style_css = '';

			newval['text-color'] = newval['text-color'] ? newval['text-color'] : 'inherit';
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : 'inherit';
			newval['widget-title-color'] = newval['widget-title-color'] ? newval['widget-title-color'] : 'inherit';

			// Text color.
			style_css += '#colophon { color: ' + newval['text-color'] + '; }';

			// Link color.
			style_css += '#colophon a { color: ' + newval['link-color'] + '; }';

			// Link hover color.
			style_css += '#colophon a:hover, #colophon li.current_page_item > a, #colophon .blogshammir-social-nav > ul > li > a .blogshammir-icon.bottom-icon ' + '{ color: ' + newval['link-hover-color'] + '; }';

			// Widget title color.
			style_css += '#colophon .widget-title, #colophon .wp-block-heading, #colophon .wp-block-search__label { color: ' + newval['widget-title-color'] + '; }';

			// Copyright separator color.
			copyright_separator_color = blogshammir_light_or_dark(newval['text-color'], 'rgba(255,255,255,0.1)', 'rgba(0,0,0,0.1)');

			// copyright_separator_color = blogshammir_luminance( newval['text-color'], 0.8 );

			style_css += '#blogshammir-copyright.contained-separator > .blogshammir-container:before { background-color: ' + copyright_separator_color + '; }';
			style_css += '#blogshammir-copyright.fw-separator { border-top-color: ' + copyright_separator_color + '; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Footer border.
	 */
	api('blogshammir_footer_border', function (value) {
		value.bind(function (newval) {
			var $footer = $('#blogshammir-footer');

			if (!$footer.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_footer_border');
			var style_css = '';

			if (newval['border-top-width']) {
				style_css += '#colophon { ' + 'border-top-width: ' + newval['border-top-width'] + 'px;' + 'border-top-style: ' + newval['border-style'] + ';' + 'border-top-color: ' + newval['border-color'] + ';' + '}';
			}

			if (newval['border-bottom-width']) {
				style_css += '#colophon { ' + 'border-bottom-width: ' + newval['border-bottom-width'] + 'px;' + 'border-bottom-style: ' + newval['border-style'] + ';' + 'border-bottom-color: ' + newval['border-color'] + ';' + '}';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Copyright layout.
	 */
	api('blogshammir_copyright_layout', function (value) {
		value.bind(function (newval) {
			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-copyright-layout-\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-copyright-' + newval);
		});
	});

	/**
	 * Copyright separator.
	 */
	api('blogshammir_copyright_separator', function (value) {
		value.bind(function (newval) {
			var $copyright = $('#blogshammir-copyright');

			if (!$copyright.length) {
				return;
			}

			$copyright.removeClass('fw-separator contained-separator');

			if ('none' !== newval) {
				$copyright.addClass(newval);
			}
		});
	});

	/**
	 * Copyright visibility.
	 */
	api('blogshammir_copyright_visibility', function (value) {
		value.bind(function (newval) {
			blogshammir_print_visibility_classes($('#blogshammir-copyright'), newval);
		});
	});

	/**
	 * Copyright background.
	 */
	api('blogshammir_copyright_background', function (value) {
		value.bind(function (newval) {
			var $copyright = $('#blogshammir-copyright');

			if (!$copyright.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_copyright_background');
			var style_css = blogshammir_design_options_css('#blogshammir-copyright', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Copyright text color.
	 */
	api('blogshammir_copyright_text_color', function (value) {
		value.bind(function (newval) {
			var $copyright = $('#blogshammir-copyright');

			if (!$copyright.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_copyright_text_color');
			var style_css = '';

			newval['text-color'] = newval['text-color'] ? newval['text-color'] : 'inherit';
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : 'inherit';

			// Text color.
			style_css += '#blogshammir-copyright { color: ' + newval['text-color'] + '; }';

			// Link color.
			style_css += '#blogshammir-copyright a { color: ' + newval['link-color'] + '; }';

			// Link hover color.
			style_css +=
				'#blogshammir-copyright a:hover, #blogshammir-copyright .blogshammir-social-nav > ul > li > a .blogshammir-icon.bottom-icon, #blogshammir-copyright li.current_page_item > a, #blogshammir-copyright .blogshammir-nav > ul > li.current-menu-item > a, #blogshammir-copyright .blogshammir-nav > ul > li.current-menu-ancestor > a #blogshammir-copyright .blogshammir-nav > ul > li:hover > a, #blogshammir-copyright .blogshammir-social-nav > ul > li > a .blogshammir-icon.bottom-icon { color: ' +
				newval['link-hover-color'] +
				'; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Container width.
	 */
	api('blogshammir_container_width', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_container_width');
			var style_css;

			style_css = '.blogshammir-container, .alignfull > div { max-width: ' + newval.value + 'px; } ' +
				'.blogshammir-header-layout-5:not(.blogshammir-sticky-header) #blogshammir-header #blogshammir-header-inner, .blogshammir-header-layout-5 #masthead+#main .blogshammir-breadcrumbs { max-width: calc(' + newval.value + 'px - 8rem); }';

			style_css +=
				'.blogshammir-layout__boxed #page, .blogshammir-layout__boxed.blogshammir-sticky-header.blogshammir-is-mobile #blogshammir-header-inner, ' +
				'.blogshammir-layout__boxed.blogshammir-sticky-header:not(.blogshammir-header-layout-3,.blogshammir-header-layout-4,.blogshammir-header-layout-6) #blogshammir-header-inner, ' +
				'.blogshammir-layout__boxed.blogshammir-sticky-header:not(.blogshammir-is-mobile).blogshammir-header-layout-6 #blogshammir-header-inner .blogshammir-nav-container > .blogshammir-container ' +
				'.blogshammir-layout__boxed.blogshammir-sticky-header:not(.blogshammir-is-mobile).blogshammir-header-layout-4 #blogshammir-header-inner .blogshammir-nav-container > .blogshammir-container ' +
				'.blogshammir-layout__boxed.blogshammir-sticky-header:not(.blogshammir-is-mobile).blogshammir-header-layout-3 #blogshammir-header-inner .blogshammir-nav-container > .blogshammir-container { max-width: ' +
				(parseInt(newval.value) + 100) +
				'px; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Transparent Header Logo max height.
	 */
	api('blogshammir_tsp_logo_max_height', function (value) {
		value.bind(function (newval) {
			var $logo = $('.blogshammir-tsp-header .blogshammir-logo');

			if (!$logo.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_tsp_logo_max_height');
			var style_css = '';

			style_css += blogshammir_range_field_css('.blogshammir-tsp-header .blogshammir-logo img', 'max-height', newval, true, 'px');
			style_css += blogshammir_range_field_css('.blogshammir-tsp-header .blogshammir-logo img.blogshammir-svg-logo', 'height', newval, true, 'px');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Transparent Header Logo margin.
	 */
	api('blogshammir_tsp_logo_margin', function (value) {
		value.bind(function (newval) {
			var $logo = $('.blogshammir-tsp-header .blogshammir-logo');

			if (!$logo.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_tsp_logo_margin');

			var style_css = blogshammir_spacing_field_css('.blogshammir-tsp-header .blogshammir-logo .logo-inner', 'margin', newval, true);
			$style_tag.html(style_css);
		});
	});

	/**
	 * Transparent header - Main Header & Topbar background.
	 */
	api('blogshammir_tsp_header_background', function (value) {
		value.bind(function (newval) {
			var $tsp_header = $('.blogshammir-tsp-header');

			if (!$tsp_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_tsp_header_background');

			var style_css = '';
			style_css += blogshammir_design_options_css('.blogshammir-tsp-header #blogshammir-header-inner', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Transparent header - Main Header & Topbar font color.
	 */
	api('blogshammir_tsp_header_font_color', function (value) {
		value.bind(function (newval) {
			var $tsp_header = $('.blogshammir-tsp-header');

			if (!$tsp_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_tsp_header_font_color');

			var style_css = '';

			newval['text-color'] = newval['text-color'] ? newval['text-color'] : 'inherit';
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : 'inherit';

			/** Header **/

			// Text color.
			style_css += '.blogshammir-tsp-header .blogshammir-logo .site-description { color: ' + newval['text-color'] + '; }';

			// Link color.
			if (newval['link-color']) {
				style_css += '.blogshammir-tsp-header #blogshammir-header, ' + '.blogshammir-tsp-header .blogshammir-header-widgets a:not(.blogshammir-btn), ' + '.blogshammir-tsp-header .blogshammir-logo a,' + '.blogshammir-tsp-header .blogshammir-hamburger, ' + '.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li > a { color: ' + newval['link-color'] + '; }';
				style_css += '.blogshammir-tsp-header .hamburger-inner,' + '.blogshammir-tsp-header .hamburger-inner::before,' + '.blogshammir-tsp-header .hamburger-inner::after { background-color: ' + newval['link-color'] + '; }';
			}

			// Link hover color.
			if (newval['link-hover-color']) {
				style_css +=
					'.blogshammir-tsp-header .blogshammir-header-widgets a:not(.blogshammir-btn):hover, ' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-header-widgets .blogshammir-active,' +
					'.blogshammir-tsp-header .blogshammir-logo .site-title a:hover, ' +
					'.blogshammir-tsp-header .blogshammir-hamburger:hover .hamburger-label, ' +
					'.is-mobile-menu-active .blogshammir-tsp-header .blogshammir-hamburger .hamburger-label,' +
					'.blogshammir-tsp-header.using-keyboard .site-title a:focus,' +
					'.blogshammir-tsp-header.using-keyboard .blogshammir-header-widgets a:not(.blogshammir-btn):focus,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.hovered > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li > a:hover,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.menu-item-has-children:hover > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-item > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.current-menu-ancestor > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.page_item_has_children:hover > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.current_page_item > a,' +
					'.blogshammir-tsp-header #blogshammir-header-inner .blogshammir-nav > ul > li.current_page_ancestor > a { color: ' +
					newval['link-hover-color'] +
					'; }';

				style_css +=
					'.blogshammir-tsp-header .blogshammir-hamburger:hover .hamburger-inner,' +
					'.blogshammir-tsp-header .blogshammir-hamburger:hover .hamburger-inner::before,' +
					'.blogshammir-tsp-header .blogshammir-hamburger:hover .hamburger-inner::after,' +
					'.is-mobile-menu-active .blogshammir-tsp-header .blogshammir-hamburger .hamburger-inner,' +
					'.is-mobile-menu-active .blogshammir-tsp-header .blogshammir-hamburger .hamburger-inner::before,' +
					'.is-mobile-menu-active .blogshammir-tsp-header .blogshammir-hamburger .hamburger-inner::after { background-color: ' +
					newval['link-hover-color'] +
					'; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Transparent header - Main Header & Topbar border.
	 */
	api('blogshammir_tsp_header_border', function (value) {
		value.bind(function (newval) {
			var $tsp_header = $('.blogshammir-tsp-header');

			if (!$tsp_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_tsp_header_border');

			var style_css = '';

			style_css += blogshammir_design_options_css('.blogshammir-tsp-header #blogshammir-header-inner', newval, 'border');

			// Separator color.
			newval['separator-color'] = newval['separator-color'] ? newval['separator-color'] : 'inherit';
			style_css += '.blogshammir-tsp-header .blogshammir-header-widget:after { background-color: ' + newval['separator-color'] + '; }';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Page Header layout.
	 */
	api('blogshammir_page_header_alignment', function (value) {
		value.bind(function (newval) {
			if ($body.hasClass('single-post')) {
				return;
			}

			$body.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-page-title-align-\S+/g) || []).join(' ');
			});

			$body.addClass('blogshammir-page-title-align-' + newval);
		});
	});

	/**
	 * Page Header spacing.
	 */
	api('blogshammir_page_header_spacing', function (value) {
		value.bind(function (newval) {
			var $page_header = $('.page-header');

			if (!$page_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_page_header_spacing');

			var style_css = blogshammir_spacing_field_css('.blogshammir-page-title-align-left .page-header.blogshammir-has-page-title, .blogshammir-page-title-align-right .page-header.blogshammir-has-page-title, .blogshammir-page-title-align-center .page-header .blogshammir-page-header-wrapper', 'padding', newval, true);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Page Header background.
	 */
	api('blogshammir_page_header_background', function (value) {
		value.bind(function (newval) {
			var $page_header = $('.page-header');

			if (!$page_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_page_header_background');

			var style_css = '';
			style_css += blogshammir_design_options_css('.page-header', newval, 'background');
			style_css += blogshammir_design_options_css('.blogshammir-tsp-header:not(.blogshammir-tsp-absolute) #masthead', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Header Text color.
	 */
	api('blogshammir_page_header_text_color', function (value) {
		value.bind(function (newval) {
			var $page_header = $('.page-header');

			if (!$page_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_page_header_text_color');
			var style_css = '';

			newval['text-color'] = newval['text-color'] ? newval['text-color'] : 'inherit';
			newval['link-color'] = newval['link-color'] ? newval['link-color'] : 'inherit';
			newval['link-hover-color'] = newval['link-hover-color'] ? newval['link-hover-color'] : 'inherit';

			// Text color.
			style_css += '.page-header .page-title { color: ' + newval['text-color'] + '; }';
			style_css += '.page-header .blogshammir-page-header-description' + '{ color: ' + blogshammir_hex2rgba(newval['text-color'], 0.75) + '}';

			// Link color.
			style_css += '.page-header .blogshammir-breadcrumbs a' + '{ color: ' + newval['link-color'] + '; }';

			style_css += '.page-header .blogshammir-breadcrumbs span,' + '.page-header .breadcrumb-trail .trail-items li::after, .page-header .blogshammir-breadcrumbs .separator' + '{ color: ' + blogshammir_hex2rgba(newval['link-color'], 0.75) + '}';

			$style_tag.html(style_css);
		});
	});

	/**
	 * Page Header border.
	 */
	api('blogshammir_page_header_border', function (value) {
		value.bind(function (newval) {
			var $page_header = $('.page-header');

			if (!$page_header.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_page_header_border');
			var style_css = blogshammir_design_options_css('.page-header', newval, 'border');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Breadcrumbs alignment.
	 */
	api('blogshammir_breadcrumbs_alignment', function (value) {
		value.bind(function (newval) {
			var $breadcrumbs = $('#main > .blogshammir-breadcrumbs > .blogshammir-container');

			if (!$breadcrumbs.length) {
				return;
			}

			$breadcrumbs.removeClass(function (index, className) {
				return (className.match(/(^|\s)blogshammir-text-align\S+/g) || []).join(' ');
			});

			$breadcrumbs.addClass('blogshammir-text-align-' + newval);
		});
	});

	/**
	 * Breadcrumbs spacing.
	 */
	api('blogshammir_breadcrumbs_spacing', function (value) {
		value.bind(function (newval) {
			var $breadcrumbs = $('.blogshammir-breadcrumbs');

			if (!$breadcrumbs.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_breadcrumbs_spacing');

			var style_css = blogshammir_spacing_field_css('.blogshammir-breadcrumbs', 'padding', newval, true);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Breadcrumbs Background.
	 */
	api('blogshammir_breadcrumbs_background', function (value) {
		value.bind(function (newval) {
			var $breadcrumbs = $('.blogshammir-breadcrumbs');

			if (!$breadcrumbs.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_breadcrumbs_background');
			var style_css = blogshammir_design_options_css('.blogshammir-breadcrumbs', newval, 'background');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Breadcrumbs Text Color.
	 */
	api('blogshammir_breadcrumbs_text_color', function (value) {
		value.bind(function (newval) {
			var $breadcrumbs = $('.blogshammir-breadcrumbs');

			if (!$breadcrumbs.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_breadcrumbs_text_color');
			var style_css = blogshammir_design_options_css('.blogshammir-breadcrumbs', newval, 'color');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Breadcrumbs Border.
	 */
	api('blogshammir_breadcrumbs_border', function (value) {
		value.bind(function (newval) {
			var $breadcrumbs = $('.blogshammir-breadcrumbs');

			if (!$breadcrumbs.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_breadcrumbs_border');
			var style_css = blogshammir_design_options_css('.blogshammir-breadcrumbs', newval, 'border');

			$style_tag.html(style_css);
		});
	});

	/**
	 * Base HTML font size.
	 */
	api('blogshammir_html_base_font_size', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_html_base_font_size');
			var style_css = blogshammir_range_field_css('html', 'font-size', newval, true, '%');
			$style_tag.html(style_css);
		});
	});

	/**
	 * Font smoothing.
	 */
	api('blogshammir_font_smoothing', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_font_smoothing');

			if (newval) {
				$style_tag.html('*,' + '*::before,' + '*::after {' + '-moz-osx-font-smoothing: grayscale;' + '-webkit-font-smoothing: antialiased;' + '}');
			} else {
				$style_tag.html('*,' + '*::before,' + '*::after {' + '-moz-osx-font-smoothing: auto;' + '-webkit-font-smoothing: auto;' + '}');
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_html_base_font_size');
			var style_css = blogshammir_range_field_css('html', 'font-size', newval, true, '%');
			$style_tag.html(style_css);
		});
	});

	/**
	 * Body font.
	 */
	api('blogshammir_body_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_body_font');
			var style_css = blogshammir_typography_field_css('body', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Headings font.
	 */
	api('blogshammir_headings_font', function (value) {
		var style_css, selector;
		value.bind(function (newval) {
			selector = 'h1, .h1, .blogshammir-logo .site-title, .page-header h1.page-title';
			selector += ', h2, .h2, .woocommerce div.product h1.product_title';
			selector += ', h3, .h3, .woocommerce #reviews #comments h2';
			selector += ', h4, .h4, .woocommerce .cart_totals h2, .woocommerce .cross-sells > h4, .woocommerce #reviews #respond .comment-reply-title';
			selector += ', h5, h6, .h5, .h6';

			style_css = blogshammir_typography_field_css(selector, newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag = blogshammir_get_style_tag('blogshammir_headings_font');
			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 1 font.
	 */
	api('blogshammir_h1_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h1_font');

			var style_css = blogshammir_typography_field_css('h1, .h1, .blogshammir-logo .site-title, .page-header h1.page-title', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 2 font.
	 */
	api('blogshammir_h2_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h2_font');

			var style_css = blogshammir_typography_field_css('h2, .h2, .woocommerce div.product h1.product_title', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 3 font.
	 */
	api('blogshammir_h3_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h3_font');

			var style_css = blogshammir_typography_field_css('h3, .h3, .woocommerce #reviews #comments h2', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 4 font.
	 */
	api('blogshammir_h4_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h4_font');

			var style_css = blogshammir_typography_field_css('h4, .h4, .woocommerce .cart_totals h2, .woocommerce .cross-sells > h4, .woocommerce #reviews #respond .comment-reply-title', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 5 font.
	 */
	api('blogshammir_h5_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h5_font');
			var style_css = blogshammir_typography_field_css('h5, .h5', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading 6 font.
	 */
	api('blogshammir_h6_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_h6_font');
			var style_css = blogshammir_typography_field_css('h6, .h6', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Heading emphasized font.
	 */
	api('blogshammir_heading_em_font', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_heading_em_font');
			var style_css = blogshammir_typography_field_css('h1 em, h2 em, h3 em, h4 em, h5 em, h6 em, .h1 em, .h2 em, .h3 em, .h4 em, .h5 em, .h6 em, .blogshammir-logo .site-title em, .error-404 .page-header h1 em', newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Footer widget title font size.
	 */
	api('blogshammir_footer_widget_title_font_size', function (value) {
		value.bind(function (newval) {
			var $widget_title = $('#colophon .widget-title, #colophon .wp-block-heading');

			if (!$widget_title.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_footer_widget_title_font_size');
			var style_css = '';

			style_css += blogshammir_range_field_css('#colophon .widget-title, #colophon .wp-block-heading', 'font-size', newval, true, newval.unit);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Page title font size.
	 */
	api('blogshammir_page_header_font_size', function (value) {
		value.bind(function (newval) {
			var $page_title = $('.page-header .page-title');

			if (!$page_title.length) {
				return;
			}

			$style_tag = blogshammir_get_style_tag('blogshammir_page_header_font_size');
			var style_css = '';

			style_css += blogshammir_range_field_css('#page .page-header .page-title', 'font-size', newval, true, newval.unit);

			$style_tag.html(style_css);
		});
	});

	var $btn_selectors =
		'.blogshammir-btn, ' +
		'body:not(.wp-customizer) input[type=submit], ' +
		'.site-main .woocommerce #respond input#submit, ' +
		'.site-main .woocommerce a.button, ' +
		'.site-main .woocommerce button.button, ' +
		'.site-main .woocommerce input.button, ' +
		'.woocommerce ul.products li.product .added_to_cart, ' +
		'.woocommerce ul.products li.product .button, ' +
		'.woocommerce div.product form.cart .button, ' +
		'.woocommerce #review_form #respond .form-submit input, ' +
		'#infinite-handle span';

	var $btn_hover_selectors =
		'.blogshammir-btn:hover, ' +
		'.blogshammir-btn:focus, ' +
		'body:not(.wp-customizer) input[type=submit]:hover, ' +
		'body:not(.wp-customizer) input[type=submit]:focus, ' +
		'.site-main .woocommerce #respond input#submit:hover, ' +
		'.site-main .woocommerce #respond input#submit:focus, ' +
		'.site-main .woocommerce a.button:hover, ' +
		'.site-main .woocommerce a.button:focus, ' +
		'.site-main .woocommerce button.button:hover, ' +
		'.site-main .woocommerce button.button:focus, ' +
		'.site-main .woocommerce input.button:hover, ' +
		'.site-main .woocommerce input.button:focus, ' +
		'.woocommerce ul.products li.product .added_to_cart:hover, ' +
		'.woocommerce ul.products li.product .added_to_cart:focus, ' +
		'.woocommerce ul.products li.product .button:hover, ' +
		'.woocommerce ul.products li.product .button:focus, ' +
		'.woocommerce div.product form.cart .button:hover, ' +
		'.woocommerce div.product form.cart .button:focus, ' +
		'.woocommerce #review_form #respond .form-submit input:hover, ' +
		'.woocommerce #review_form #respond .form-submit input:focus, ' +
		'#infinite-handle span:hover';

	/**
	 * Primary button background color.
	 */
	api('blogshammir_primary_button_bg_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_bg_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_selectors + '{ background-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button hover background color.
	 */
	api('blogshammir_primary_button_hover_bg_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_hover_bg_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_hover_selectors + ' { background-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button text color.
	 */
	api('blogshammir_primary_button_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_selectors + ' { color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button hover text color.
	 */
	api('blogshammir_primary_button_hover_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_hover_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_hover_selectors + ' { color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button border width.
	 */
	api('blogshammir_primary_button_border_width', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_border_width');
			var style_css = '';

			if (newval) {
				style_css = $btn_selectors + ' { border-width: ' + newval.value + 'rem; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button border radius.
	 */
	api('blogshammir_primary_button_border_radius', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_border_radius');
			var style_css = '';

			if (newval) {
				style_css = $btn_selectors + ' { ' + 'border-top-left-radius: ' + newval['top-left'] + 'rem;' + 'border-top-right-radius: ' + newval['top-right'] + 'rem;' + 'border-bottom-left-radius: ' + newval['bottom-left'] + 'rem;' + 'border-bottom-right-radius: ' + newval['bottom-right'] + 'rem; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button border color.
	 */
	api('blogshammir_primary_button_border_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_border_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_selectors + ' { border-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button hover border color.
	 */
	api('blogshammir_primary_button_hover_border_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_hover_border_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_hover_selectors + ' { border-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Primary button typography.
	 */
	api('blogshammir_primary_button_typography', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_primary_button_typography');
			var style_css = blogshammir_typography_field_css($btn_selectors, newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	// Secondary button.
	var $btn_sec_selectors = '.btn-secondary, .blogshammir-btn.btn-secondary';

	var $btn_sec_hover_selectors = '.btn-secondary:hover, ' + '.btn-secondary:focus, ' + '.blogshammir-btn.btn-secondary:hover, ' + '.blogshammir-btn.btn-secondary:focus';

	/**
	 * Secondary button background color.
	 */
	api('blogshammir_secondary_button_bg_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_bg_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_selectors + '{ background-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button hover background color.
	 */
	api('blogshammir_secondary_button_hover_bg_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_hover_bg_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_hover_selectors + '{ background-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button text color.
	 */
	api('blogshammir_secondary_button_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_selectors + '{ color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button hover text color.
	 */
	api('blogshammir_secondary_button_hover_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_hover_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_hover_selectors + '{ color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button border width.
	 */
	api('blogshammir_secondary_button_border_width', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_border_width');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_selectors + ' { border-width: ' + newval.value + 'rem; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button border radius.
	 */
	api('blogshammir_secondary_button_border_radius', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_border_radius');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_selectors + ' { ' + 'border-top-left-radius: ' + newval['top-left'] + 'rem;' + 'border-top-right-radius: ' + newval['top-right'] + 'rem;' + 'border-bottom-left-radius: ' + newval['bottom-left'] + 'rem;' + 'border-bottom-right-radius: ' + newval['bottom-right'] + 'rem; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button border color.
	 */
	api('blogshammir_secondary_button_border_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_border_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_selectors + ' { border-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button hover border color.
	 */
	api('blogshammir_secondary_button_hover_border_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_hover_border_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_sec_hover_selectors + ' { border-color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Secondary button typography.
	 */
	api('blogshammir_secondary_button_typography', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_secondary_button_typography');
			var style_css = blogshammir_typography_field_css($btn_sec_selectors, newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	// Text button.
	var $btn_text_selectors = '.blogshammir-btn.btn-text-1, .btn-text-1';

	var $btn_text_hover_selectors = '.blogshammir-btn.btn-text-1:hover, .blogshammir-btn.btn-text-1:focus, .btn-text-1:hover, .btn-text-1:focus';

	/**
	 * Text button text color.
	 */
	api('blogshammir_text_button_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_text_button_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_text_selectors + '{ color: ' + newval + '; }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Text button hover text color.
	 */
	api('blogshammir_text_button_hover_text_color', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_text_button_hover_text_color');
			var style_css = '';

			if (newval) {
				style_css = $btn_text_hover_selectors + '{ color: ' + newval + '; }';
				style_css += '.blogshammir-btn.btn-text-1 > span::before { background-color: ' + newval + ' }';
			}

			$style_tag.html(style_css);
		});
	});

	/**
	 * Text button typography.
	 */
	api('blogshammir_text_button_typography', function (value) {
		value.bind(function (newval) {
			$style_tag = blogshammir_get_style_tag('blogshammir_text_button_typography');
			var style_css = blogshammir_typography_field_css($btn_text_selectors, newval);

			blogshammir_enqueue_google_font(newval['font-family']);

			$style_tag.html(style_css);
		});
	});

	/**
	 * Section Heading Style Enable.
	 */
	api('blogshammir_section_heading_style', function (value) {
		value.bind(function (newval) {
			$body
				.removeClass(function (index, className) {
					return (className.match(/(^|\s)is-section-heading-init-s\S+/g) || []).join(' ');
				})
				.addClass('is-section-heading-init-s' + api.value('blogshammir_section_heading_style')());
		});
	});


	// Selective refresh.
	if (api.selectiveRefresh) {

		// Bind partial content rendered event.
		api.selectiveRefresh.bind('partial-content-rendered', function (placement) {

			// Hero Slider.
			if ('blogshammir_hero_slider_post_number' === placement.partial.id || 'blogshammir_hero_slider_elements' === placement.partial.id || 'blogshammir_hero_type' === placement.partial.id) {
				document.querySelectorAll(placement.partial.params.selector).forEach((item) => {
					blogshammirHeroSlider(item);
					document.querySelectorAll('#' + item.id + ' .blogshammir-swiper').forEach(blogshammirSliderInit);
				});
			}

			// PYML Post.
			if ('blogshammir_pyml_post_number' === placement.partial.id || 'blogshammir_pyml_elements' === placement.partial.id) {
				document.querySelectorAll(placement.partial.params.selector).forEach((item) => {
					document.querySelectorAll('#' + item.id + ' .blogshammir-swiper').forEach(blogshammirSliderInit);
				});
			}

			// Preloader style.
			if ('blogshammir_preloader_style' === placement.partial.id) {
				$body.removeClass('blogshammir-loaded');

				setTimeout(function () {
					window.blogshammir.preloader();
				}, 300);
			}
		});
	}

	// Custom Customizer Preview class (attached to the Customize API)
	api.blogshammirCustomizerPreview = {

		// Init
		init: function () {
			var self = this; // Store a reference to "this"
			var previewBody = self.preview.body;

			previewBody.on('click', '.blogshammir-set-widget', function () {
				self.preview.send('set-footer-widget', $(this).data('sidebar-id'));
			});
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
	 *
	 * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
	 */
	var blogshammirOldPreview = api.Preview;
	api.Preview = blogshammirOldPreview.extend({
		initialize: function (params, options) {

			// Store a reference to the Preview
			api.blogshammirCustomizerPreview.preview = this;

			// Call the old Preview's initialize function
			blogshammirOldPreview.prototype.initialize.call(this, params, options);
		}
	});

	// Document ready
	$(function () {

		// Initialize our Preview
		api.blogshammirCustomizerPreview.init();
	});
}(jQuery));

