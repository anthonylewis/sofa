<?php
/**
 * A really simple weblog...
 *
 *	create table if not exists entry (
 *		id int not null auto_increment primary key,
 *		title varchar(255),
 *		entry_text text,
 *		post_date datetime,
 *		author varchar(255)
 *	);
 *
 */

require_once( 'model.php' );

class Entry extends Model {
	var $id, $title, $entry_text, $post_date, $author;

	function Entry( $id=0, $title='', $entry_text='', $post_date='', $author='' ) {
		$this->id = $id;
		$this->title = $title;
		$this->entry_text = $entry_text;
		$this->post_date = $post_date;
		$this->author = $author;

		// call base class constructor
		$this->Model( "entry" );
	}

	function fill( $row ) {
		$this->id = $row['id'];
		$this->title = $this->db->unescape_string( $row['title'] );
		$this->entry_text = $this->db->unescape_string( $row['entry_text'] );
		$this->post_date = $row['post_date'];
		$this->author = $this->db->unescape_string( $row['author'] );
	}

	// insert or update based on current data
	function save() {
		$numrows = 0;
		if ( $this->id == 0 ) {
			// insert
			$sql = "insert into entry ( title, entry_text, post_date, author ) values " . 
			       "( '$this->title', '$this->entry_text', NOW(), '$this->author' )";
			$numrows = $this->db->insert( $sql );
			if ( $numrows > 0 ) {
				$this->id = $this->db->insert_id();
			}
		}
		else {
			// update
			$sql = "update entry set title = '$this->title', " . 
			       "entry_text = '$this->entry_text', post_date = '$this->post_date' " .
			       "author = '$this->author' where id = $this->id";
			$numrows = $this->db->update( $sql );
		}
		return $numrows;
	}

	// this should be part of the "business logic"
	function parseForm() {
		$this->title = $this->db->escape_string( $_REQUEST['title'] );
		$this->entry_text = $this->db->escape_string( $_REQUEST['entry_text'] );
		// TODO: handle the date for now I'm just using NOW()
		$this->author = $this->db->escape_string( $_REQUEST['author'] );
	}

	// also part of the "business logic"
	function formatText() {
		$str = $this->entry_text;
		
		// take care of amps and quotes
		$str = str_replace( "&", "&amp;", $str );
		$str = str_replace( "\"", "&quot;", $str );
		
		// convert newlines to UNIX format
		$str = str_replace( "\r\n", "\n", $str );
		$str = str_replace( "\r", "\n", $str );

		// seperate into paragraphs
		$paras = explode( "\n\n", $str );

		// add line breaks
		foreach( $paras as $key => $val ) {
			$paras[$key] = str_replace( "\n", "<br />\n", $paras[$key] );
			$paras[$key] = "<p>" . $paras[$key] . "</p>\n";
		}

		// recombine the paragraphs
		$str = implode( "\n", $paras );
		return $str;
	}
	
	// more business logic stuff
	function formatDate() {
		// split a MySQL date into components
		list( $date, $time ) = explode( ' ', $this->post_date );
		list( $year, $month, $day ) = explode( '-', $date );
		list( $hour, $minute, $second ) = explode( ':', $time );

		$months = array( 'January', 'February', 'March', 'April', 
				 'May', 'June', 'July', 'August', 
				 'September', 'October', 'November', 'December' );

		$am_pm = 'AM';

		if ( $hour > 12 ) {
			$hour -= 12;
			$am_pm = 'PM';
		}

		return "{$months[$month - 1]} $day, $year at $hour:$minute $am_pm";
	}
}
?>
