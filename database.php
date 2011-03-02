<?php

/**
 * database.php
 *	Generic database and results classes
 *
 * TODO: eliminate the Results object and
 *       just return an array of rows?
 *
 */

require_once('config.php');

class Database {
	function Database( $dbhost='', $dbuser='', $dbpass='', $dbname='' ) {
		// initialize member variables
		if ( $dbhost == '' ) {
			// use global values
			global $config;
			$this->dbhost = $config['dbhost'];
			$this->dbuser = $config['dbuser'];
			$this->dbpass = $config['dbpass'];
			$this->dbname = $config['dbname'];
		}
		else {
			// use parameters
			$this->dbhost = $dbhost;
			$this->dbuser = $dbuser;
			$this->dbpass = $dbpass;
			$this->dbname = $dbname;
		}

		// not yet connected to the database
		$this->dblink = NULL;
		$this->connected = false;
	}

	function test_connection() {
		if ( $this->connected == false ) {
			$this->connect();
			$this->connected = true;
		}
	}

	function connect() {
		$this->dblink = mysql_connect( $this->dbhost, $this->dbuser, $this->dbpass )
			or die( 'Can not connect: ' . $this->error() );

		mysql_select_db( $this->dbname, $this->dblink )
			or die( "Can not use $this->dbname: " . $this->error() );
	}

	function &query( $sql ) {
		$this->test_connection();
		$result = mysql_query( $sql, $this->dblink )
			or die( "Query problem:\n" . $sql . "\n\n" . $this->error() );

		$res = new Result( $this->dblink, $result);

		return $res;
	}

	// shortcut query method for selecting rows
	function &select( $sql ) {
		$this->test_connection();
		$result = mysql_query( $sql, $this->dblink )
			or die( "Query problem:\n" . $sql . "\n\n" . $this->error() );

		$res = new Result( $this->dblink, $result);

		return $res;
	}

	// shortcut query method for inserting rows
	function insert( $sql ) {
		$this->test_connection();
		mysql_query( $sql, $this->dblink )
			or die( "Query problem:\n" . $sql . "\n\n" . $this->error() );
		
		return $this->affected_rows();
	}
	
	function insert_id() {
		$this->test_connection();
		return mysql_insert_id( $this->dblink );
	}
	
	// shortcut query method for updating rows
	function update( $sql ) {
		$this->test_connection();
		mysql_query( $sql, $this->dblink )
			or die( "Query problem:\n" . $sql . "\n\n" . $this->error() );
		
		return $this->affected_rows();
	}

	// shortcut query method for deleting rows
	function delete( $sql ) {
		$this->test_connection();
		mysql_query( $sql, $this->dblink )
			or die( "Query problem:\n" . $sql . "\n\n" . $this->error() );
		
		return $this->affected_rows();
	}

	// number of rows affected by last insert, update, or delete
	function affected_rows() {
		$this->test_connection();
		return mysql_affected_rows( $this->dblink );
	}

	function escape_string( $str ) {
		return mysql_escape_string( $str );
	}

	function unescape_string( $str ) {
		// TODO: fix this
		return stripslashes( $str );
	}

	function disconnect() {
		if ( $this->connected == true ) {
			mysql_close( $this->dblink );
		}
	}

	function error() {
		return mysql_error();
	}

	var $dbuser;
	var $dbhost;
	var $dbpass;
	var $dbname;
	var $dblink;
	var $connected;
}

class Result {
	function Result( $dblink, $result ) {
		$this->dblink = $dblink;
		$this->result = $result;
	}

	function data_seek( $n ) {
		mysql_data_seek( $this->result, $n );
	}

	function num_rows() {
		return mysql_num_rows( $this->result );
	}

	function fetch_row() {
		return mysql_fetch_row( $this->result );
	}
	
	function fetch_array() {
		return mysql_fetch_array( $this->result );
	}

	function fetch_assoc() {
		return mysql_fetch_assoc( $this->result );
	}

	function free() {
		mysql_free_result( $this->result );
	}

	var $dblink;
	var $result;
}
?>
