<?php
declare(strict_types=1);

class Securite
{
  // Données entrantes
  public static function bdd($link, $string)
  {
    $string = mysqli_real_escape_string($link, $string);
    $string = addcslashes($string, '%_');

    return $string;
  }

  // Données sortantes
  public static function html($string)
  {
    return htmlentities($string);
  }
}
?>
