<?php

/**
 * model.php
 *  Base class for all database tables
 *
 */

require_once( 'database.php' );

class Model {
  var $db, $result, $table, $id;

  function Model( $table ) {
    $this->db = new Database();
    $this->result = NULL;
    $this->table = $table;
  }

  // fill member variables with data from the given row
  function fill( $row ) {
    // base class does nothing
  }

  // validate the data currently in the model
  function validate() {
    // base class does nothing
  }

  // write the member variables to the database
  function save() {
    // base class does nothing
  }

  // retrieve a particular record from the database
  function get( $id ) {
    if ( !is_null( $this->result ) ) {
      $this->free_result();
    }

    $sql = "select * from $this->table where id = $id";
    $this->result = $this->db->select( $sql );

    if ( $row = $this->result->fetch_assoc() ) {
      $this->fill( $row );
      return 1;
    }
    else {
      return 0;
    }
  }

  // retrieve a record using a where clause
  function get_where( $where='' ) {
    if ( !is_null( $this->result ) ) {
      $this->free_result();
    }

    $sql = "select * from $this->table";
    if ( $where != '' ) {
      $sql .= " where $where";
    }

    $this->result = $this->db->select( $sql );

    if ( $row = $this->result->fetch_assoc() ) {
      $this->fill( $row );
      return 1;
    }
    else {
      return 0;
    }
  }

  // get a list of rows
  function get_list( $where='', $order='', $count=0, $offset=0 ) {
    if ( !is_null( $this->result ) ) {
      $this->free_result();
    }

    $sql = "select * from $this->table";
    if ( $where != '' ) {
      $sql .= " where $where";
    }
    if ( $order != '' ) {
      $sql .= " order by $order";
    }
    if ( $count > 0 ) {
      $sql .= " limit $offset, $count";
    }
    else if ( $offset > 0 ) {
      $sql .= " limit $offset, 10000";
    }
    $this->result = $this->db->select( $sql );

    return $this->result->num_rows();
  }

  // move to the next row in the set
  function next() {
    if ( is_null( $this->result ) ) {
      return 0;
    }

    if ( $row = $this->result->fetch_assoc() ) {
      $this->fill( $row );
      return 1;
    }
    else {
      // clean up the result object
      $this->free_result();
      return 0;
    }
  }

  // delete the current row by id
  function delete() {
    $numrows = 0;
    if ( $this->id > 0 ) {
      $sql = "delete from $this->table where id = $this->id";
      $numrows = $this->db->delete( $sql );
    }
    return $numrows;
  }

  // does not affect $this->result...
  function count( $where ) {
    $sql = "select count(*) from $this->table";
    if ( $where != '' ) {
      $sql .= " where $where";
    }
    
    $result = $this->db->select( $sql );
    $row = $result->fetch_row();
    $count = $row[0];
    $result->free();
    
    return $count;
  }

  // does not affect $this->result...
  function columns() {
    $sql = "show columns from $this->table";

    $result = $this->db->select( $sql );
    while ( $row = $result->fetch_assoc() ) {
      $col[] = $row['Field'];
    }

    return $col;
  }

  // free the current result set
  function free_result() {
    $this->result->free();
    $this->result = NULL;
  }

}

?>
