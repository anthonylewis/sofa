<?php
/**
 * A PHP User Manager.
 *
 */

require_once( 'session.php' );
require_once( 'database.php' );
 
class Userman {
	function Userman() {
		$this->session = new Session();
	}

	/* Return true if the user is logged in, false otherwise */
	function check_login() {
		$logged_in = 0;
	
		if ( !$this->session->get( 'username' ) or !$this->session->get( 'password' ) ) {
			$this->session->del( 'username' );
			$this->session->del( 'password' );
		}
		else {
			$username = $this->session->get( 'username' );
			$password = $this->session->get( 'password' );

			include 'db_open.php';
	
			$sql = "select * from myusers where username = '$username'";
			$result = mysql_query( $sql );
			if ( mysql_num_rows( $result ) == 1 ) {
				$row = mysql_fetch_array( $result );
	
				if ( crypt( $password, $row['password'] ) == $row['password'] ) {
					$logged_in = 1;
				}
				else {
					$this->session->del( 'username' );
					$this->session->del( 'password' );
				}
			}
			mysql_free_result( $result );
			mysql_close( $dblink );
		}
		
		return $logged_in;
	}
	
	/* If the user isn't logged in, send them to the login form */
	
	function require_login( $login_page = 'login.php' ) {
		if ( !$this->check_login() ) {
			header( "Location: $login_page" );
			exit();
		}
	}
	
	var $session;
	var $username;
	var $database;
}

?>
