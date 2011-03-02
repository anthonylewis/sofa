<?php

/**
 * maketable.php
 *	Create a table based on a database table... 
 *
 */

require_once( "util.php" );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Table Generator</title>
<link rel="stylesheet" type="text/css" href="gen.css" />
</head>
<body>
<?php
if ( empty( $_REQUEST['table'] ) ) {
?>
<form action="maketable.php" method="post">
<fieldset>
<legend>Choose Table</legend>
<label for="table">Table Name</label>
<input type="text" id="table" name="table" />
<input type="submit" class="button" value="Submit" />
</fieldset>
</form>
<?php
}
else {
  // grab the table name and generate a table
  $table = $_REQUEST['table'];
	
  require_once( 'database.php' );

  $db = new Database();

  $result = $db->query( "show columns from $table" );

  echo "<h1>" . humanize( $table ) . "</h1>\n";
  echo "<table>\n";
  echo "<tr>";

  // Column Names
  while ( $row = $result->fetch_assoc() ) {
    $field = $row['Field'];
		
    if ( $field != 'id' ) {
      echo "<th>" . humanize( $field ) . "</th>";
    }
  }
  echo "</tr>\n";

  $result->free();

  // Table Data
  $result = $db->query( "select * from $table" );

  while ( $row = $result->fetch_assoc() ) {
    echo "<tr>";
    foreach ( $row as $key => $value ) {
      if ( $key != 'id' ) {
        echo "<td>" . $value . "</td>";
      }
    }
    echo "</tr>\n";
  }
  echo "</table>\n";

  $result->free();
  $db->disconnect();
	
  echo "<div id=\"footer\">";
  echo "<a href=\"maketable.php\">Create another table</a>";
  echo "</div>";
}
?>
</body>
</html>
