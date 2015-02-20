<?php
/*
Plugin Name: CF7 Israeli Phone Validation
Description: Add Israeli phone numbers validation for CF7 tel and tel* fields.

*note:
Will work on fields with name 'il_phone', ie.  [tel* il_phone placeholder "טלפון"]
Tested with CF7 4.1 and Wordpress 4.1.1
Version: 0.3
Author: Itai Lulu Koren
Author Email: itailulu@gmail.com
License:

  Copyright 2015 Itai Koren (itailulu@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

// Add custom validation for CF7 form fields
function israeli_phone_validation_filter( $result, $tag ) {
	$tag = new WPCF7_Shortcode( $tag );

	$name = $tag->name;

	$value = isset( $_POST[$name] ) ? preg_replace('/\D+/', '', $_POST[$name]) : ''; //trims all non-numeric characters

	if ( 'tel' == $tag->basetype && $tag->name == 'il_phone') {
		$regex = '/^(050|052|053|054|055|057|058|02|03|04|08|09|072|073|076|077|078)-?\d{7,7}$/';
		if ( !preg_match($regex,  $value, $matches ) ) {
			$result->invalidate( $tag, wpcf7_get_message( 'invalid_tel' ) );
		}
	}

	return $result;
}
add_filter('wpcf7_validate_tel','israeli_phone_validation_filter', 10, 2); // Normal field
add_filter('wpcf7_validate_tel*', 'israeli_phone_validation_filter', 10, 2); // Req. field