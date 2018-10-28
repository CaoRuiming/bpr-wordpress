<?php
class OTW_Validator extends OTW_Component{
	
	/**
	 * check if given string has length
	 *
	 * @param string
	 *
	 * @return boolean
	 */
	public static function is_empty( $string ){
		
		if( !strlen( trim( $string ) ) ){
			return true;
		}
		return false;
	}
	
	/**
	 * check if given string is email
	 *
	 * @param string
	 *
	 * @return boolean
	 */
	public static function is_email( $string ){
		
		if( preg_match( "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $string, $matches ) ){
			return true;
		}
		return false;
	}
	
	/**
	 * check if given string is unsigned interger
	 *
	 * @param string
	 *
	 * @return boolean
	 */
	public static function is_unsigned( $string ){
		
		if( preg_match( "/^\d+$/", $string, $matches ) ){
			return true;
		}
		return false;
	}
}