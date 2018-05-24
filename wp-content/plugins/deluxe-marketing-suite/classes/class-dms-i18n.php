<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 */

class Deluxe_Marketing_Suite_i18n{

	public function dms_load_plugin_textdomain() {
		load_plugin_textdomain(DMS_NAME,false,DMS_DIR . 'languages/');
	}
	
}