<?php
/**
 * Plugin Name: dna Media Sidebar Expander
 * Plugin URI:  https://github.com/dnaber-de/media-sidebar-expander
 * Description: This Plugin improves the admin css to give the media sidebar more space
 * Author:      David Naber
 * Version:     2015.01.11
 * Author URI:  http://dnaber.de/
 * License:     MIT
 * License URI: http://opensource.org/licenses/MIT
 *
 *
 * Copyright (c) 2013 David Naber
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
 * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

if ( ! function_exists( 'add_filter' ) ) {
	exit( "Where's my WP?" );
}

add_action( 'plugins_loaded', array( Media_Sidebar_Expander::get_instance(), 'init_plugin'  ) );

class Media_Sidebar_Expander {

	/**
	 * Version
	 *
	 * @const string
	 */
	const VERSION = '2013.01.18';

	/**
	 * absolute path to this directory
	 *
	 * @var string
	 */
	public $dir = '';

	/**
	 * absolute URL to this directory
	 *
	 * @var string
	 */
	public $url = '';

	/**
	 * instance of self
	 *
	 * @var Media_Sidebar_Expander
	 */
	private static $instance = NULL;

	/**
	 * get the instance
	 *
	 * @return Media_Sidebar_Expander
	 */
	public static function get_instance() {

		if ( ! self::$instance instanceof self )
			self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @return Media_Sidebar_Expander
	 */
	public function __construct() {

		$this->dir = plugin_dir_path( __FILE__ );
		$this->url = plugins_url( '', __FILE__ );
	}

	/**
	 * register all neccessary stuff to WP
	 *
	 * @wp-hook plugins_loaded
	 * @return void
	 */
	public function init_plugin() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_style' ) );
	}

	/**
	 * register and enqueue the admin css
	 *
	 * @wp-hook admin_enqueue_scripts
	 * @param string $pagenow
	 * @return void
	 */
	public function enqueue_admin_style( $pagenow ) {

		wp_register_style(
			'mse_admin_style',
			$this->url . '/css/media-sidebar-expander.css',
			array(),
			self::VERSION
		);

		# you may want to change registration here
		do_action( 'mse_style_registered' );
		wp_enqueue_style( 'mse_admin_style' );
	}
}
