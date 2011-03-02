<?php

/*
 * TODO:  Update this to use session.php
 *        and database.php
 *
 */

session_start();

/* Return true if the user is logged in, false otherwise */

function check_login() {
	$logged_in = 0;

	if ( !isset($_SESSION['username']) or !isset($_SESSION['password']) ) {
		unset($_SESSION['username']);
		unset($_SESSION['password']);
	}
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];

		include 'db_open.php';

		$sql = "select * from myusers where username = '$username'";
		$result = mysql_query( $sql );
		if ( mysql_num_rows( $result ) == 1 ) {
			$row = mysql_fetch_array( $result );

			if ( crypt( $password, $row['password'] ) == $row['password'] ) {
				$logged_in = 1;
			}
			else {
				unset($_SESSION['username']);
				unset($_SESSION['password']);
			}
		}
		mysql_free_result( $result );
		mysql_close( $dblink );
	}

	return $logged_in;
}

/* If the user isn't logged in, send them to the login form */

function require_login( $login_page = 'login.php' ) {
	if ( !check_login() ) {
		header("Location: $login_page");
		exit();
	}
}

?>

