<?php

function humanize( $str ) {
  return ucwords( str_replace( "_", " ", $str ) );
}



?>