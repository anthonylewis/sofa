<?php
/**
 * A simple Task List class
 *
 *	create table task (
 *		id int not null auto_increment primary key,
 *		title varchar(255),
 *		description text,
 *		starttime datetime,
 *		deadline datetime,
 *		status int
 *	);
 *
 */

require_once( 'model.php' );

class Task extends Model {
	var $id, $title, $description, $starttime, $deadline, $status;
	
	function Task( $id=0, $title='', $description='', 
				   $starttime='', $deadline='', $status=0 ) {
		$this->id          = $id;
		$this->title       = $title;
		$this->description = $description;
		$this->starttime   = $starttime;
		$this->deadline    = $deadline;
		$this->status      = $status;
		
		// call base class constructor
		$this->Model( "task" );
	}
	
	function fill( $row ) {
		$this->id = $row['id'];
		$this->title = $this->db->unescape_string( $row['title'] );
		$this->description = $this->db->unescape_string( $row['description'] );
		$this->starttime = $row['starttime'];
		$this->deadline = $row['deadline'];
		$this->status = $row['status'];
	}
	
	// insert or update based on current data
	function save() {
		$numrows = 0;
		if ( $this->id == 0 ) {
			// insert
			$sql  = "insert into task " .
					"( title, description, starttime, deadline, status ) " .
					"values ( '$this->title', '$this->description', " .
					"'$this->starttime', '$this->deadline', $this->status )";

			$numrows = $this->db->insert( $sql );
			if ( $numrows > 0 ) {
				$this->id = $this->db->insert_id();
			}
		}
		else {
			// update
			$sql = "update task set title = '$this->title', " . 
			       "description = '$this->description', " .
				   "starttime = '$this->starttime', " .
				   "deadline = '$this->deadline', " .
			       "status = $this->status where id = $this->id";

			$numrows = $this->db->update( $sql );
		}
		return $numrows;
	}
}
?>
