<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'scientia_storage_get' ) ) {
	function scientia_storage_get( $var_name, $default = '' ) {
		global $SCIENTIA_STORAGE;
		return isset( $SCIENTIA_STORAGE[ $var_name ] ) ? $SCIENTIA_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'scientia_storage_set' ) ) {
	function scientia_storage_set( $var_name, $value ) {
		global $SCIENTIA_STORAGE;
		$SCIENTIA_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'scientia_storage_empty' ) ) {
	function scientia_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $SCIENTIA_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $SCIENTIA_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $SCIENTIA_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $SCIENTIA_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'scientia_storage_isset' ) ) {
	function scientia_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $SCIENTIA_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $SCIENTIA_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $SCIENTIA_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $SCIENTIA_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'scientia_storage_inc' ) ) {
	function scientia_storage_inc( $var_name, $value = 1 ) {
		global $SCIENTIA_STORAGE;
		if ( empty( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = 0;
		}
		$SCIENTIA_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'scientia_storage_concat' ) ) {
	function scientia_storage_concat( $var_name, $value ) {
		global $SCIENTIA_STORAGE;
		if ( empty( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = '';
		}
		$SCIENTIA_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'scientia_storage_get_array' ) ) {
	function scientia_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $SCIENTIA_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) ? $SCIENTIA_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $SCIENTIA_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $SCIENTIA_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'scientia_storage_set_array' ) ) {
	function scientia_storage_set_array( $var_name, $key, $value ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$SCIENTIA_STORAGE[ $var_name ][] = $value;
		} else {
			$SCIENTIA_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'scientia_storage_set_array2' ) ) {
	function scientia_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$SCIENTIA_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$SCIENTIA_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'scientia_storage_merge_array' ) ) {
	function scientia_storage_merge_array( $var_name, $key, $value ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$SCIENTIA_STORAGE[ $var_name ] = array_merge( $SCIENTIA_STORAGE[ $var_name ], $value );
		} else {
			$SCIENTIA_STORAGE[ $var_name ][ $key ] = array_merge( $SCIENTIA_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'scientia_storage_set_array_after' ) ) {
	function scientia_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			scientia_array_insert_after( $SCIENTIA_STORAGE[ $var_name ], $after, $key );
		} else {
			scientia_array_insert_after( $SCIENTIA_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'scientia_storage_set_array_before' ) ) {
	function scientia_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			scientia_array_insert_before( $SCIENTIA_STORAGE[ $var_name ], $before, $key );
		} else {
			scientia_array_insert_before( $SCIENTIA_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'scientia_storage_push_array' ) ) {
	function scientia_storage_push_array( $var_name, $key, $value ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $SCIENTIA_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) ) {
				$SCIENTIA_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $SCIENTIA_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'scientia_storage_pop_array' ) ) {
	function scientia_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $SCIENTIA_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $SCIENTIA_STORAGE[ $var_name ] ) && is_array( $SCIENTIA_STORAGE[ $var_name ] ) && count( $SCIENTIA_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $SCIENTIA_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) && is_array( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) && count( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $SCIENTIA_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'scientia_storage_inc_array' ) ) {
	function scientia_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( empty( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ][ $key ] = 0;
		}
		$SCIENTIA_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'scientia_storage_concat_array' ) ) {
	function scientia_storage_concat_array( $var_name, $key, $value ) {
		global $SCIENTIA_STORAGE;
		if ( ! isset( $SCIENTIA_STORAGE[ $var_name ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ] = array();
		}
		if ( empty( $SCIENTIA_STORAGE[ $var_name ][ $key ] ) ) {
			$SCIENTIA_STORAGE[ $var_name ][ $key ] = '';
		}
		$SCIENTIA_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'scientia_storage_call_obj_method' ) ) {
	function scientia_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $SCIENTIA_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $SCIENTIA_STORAGE[ $var_name ] ) ? $SCIENTIA_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $SCIENTIA_STORAGE[ $var_name ] ) ? $SCIENTIA_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'scientia_storage_get_obj_property' ) ) {
	function scientia_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $SCIENTIA_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $SCIENTIA_STORAGE[ $var_name ]->$prop ) ? $SCIENTIA_STORAGE[ $var_name ]->$prop : $default;
	}
}
