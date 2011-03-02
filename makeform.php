<?php

/**
 * makeform.php
 *	Create a form based on a database table... 
 *
 */

require_once( "util.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Form Generator</title>
<link rel="stylesheet" type="text/css" href="gen.css" />
</head>
<body>
<?php
if ( empty( $_REQUEST['table'] ) ) {
?>
<form action="makeform.php" method="post">
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
  // grab the table name and generate a form
  $table = $_REQUEST['table'];
	
  require_once( 'database.php' );

  $db = new Database();

  $result = $db->query( "show columns from $table" );

  if ( $result->num_rows() > 0 ) {
    echo "<form>\n";
    echo "<fieldset>\n";
    echo "<legend>Add " . humanize( $table ) . "</legend>\n";


    while ( $row = $result->fetch_assoc() ) {
      $field = $row['Field'];

      if ( $field == 'id' ) {
        continue;
      }

      echo "<label for=\"$field\">" . humanize( $field ) . "</label>";
      if ( $row['Type'] == 'text' ) {
        echo "<textarea id=\"$field\"></textarea>\n";
      }
      else {
        echo "<input type=\"text\" id=\"$field\" />\n";
      }
    }

    echo "<input type=\"submit\" class=\"button\" value=\"Submit\" />\n";
    echo "</fieldset>\n";
    echo "</form>\n";
  }

  $result->free();
  $db->disconnect();
	
  echo "<div id=\"footer\">";
  echo "<a href=\"makeform.php\">Create another form</a>";
  echo "</div>";
}
?>
</body>
</html>
