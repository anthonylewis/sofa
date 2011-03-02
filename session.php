<?php
/**
 * A wrapper around PHP's session functions.
 *
 *	Usage:
 *	  var $session = new Session();
 *	  $session->set( 'message', 'Hello World!' );
 *	  echo $session->get( 'message' );
 */

class Session {
	function Session() {
		session_start();
	}

	function set( $name, $value ) {
		$_SESSION[$name] = $value;
	}

	function get( $name ) {
		if ( isset( $_SESSION[$name] ) ) {
			return $_SESSION[$name];
		} else {
			return false;
		}
	}

	function del( $name ) {
		unset( $_SESSION[$name] );
	}

	function destroy() {
		$_SESSION = array();
		session_destroy();
	}
}
?>
