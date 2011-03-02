<?php

class Form {
  function Form( $action = '', $method = '' ) {
    $this->action = $action;
    $this->method = $method;
  }

  function start() {
    return "<form action=\"$this->action\" method=\"$this->method\">\n";
  }

  function text( $id, $value='', $label='' ) {
    $str = '';

    if ( $label != '' ) {
      $str .= "<label for=\"$id\">$label</label>\n";
    }

    $str .= "<input type=\"text\" id=\"$id\" name=\"$id\" value=\"$value\" />\n";

    return $str;
  }

  function password( $id, $label='' ) {
    $str = '';

    if ( $label != '' ) {
      $str .= "<label for=\"$id\">$label</label>\n";
    }

    $str .= "<input type=\"password\" id=\"$id\" name=\"$id\" />\n";

    return $str;
  }

  function textarea( $id, $value='', $label='' ) {
    $str = '';

    if ( $label != '' ) {
      $str .= "<label for=\"$id\">$label</label>\n";
    }

    $str .= "<textarea id=\"$id\" name=\"$id\">\n";
    $str .= $value;
    $str .= "</textarea>\n";

    return $str;
  }

  function submit( $id, $value ) {
    $str  = "<input type=\"submit\" ";
    $str .= "id=\"$id\" name=\"$id\" ";
    $str .= "value=\"$value\" />\n";

    return $str;
  }

  function hidden( $id, $value ) {
    $str  = "<input type=\"hidden\" ";
    $str .= "id=\"$id\" name=\"$id\" ";
    $str .= "value=\"$value\" />\n";

    return $str;
  }

  function end() {
    return "</form>\n";
  }
}

?>
