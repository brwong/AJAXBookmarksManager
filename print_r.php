<?php

echo "<pre>";
echo "COOKIE:<br/>";
echo print_r($_COOKIE, true);
echo "<br/><br/>";

echo "GET:<br/>";
echo print_r($_GET, true);
echo "<br/><br/>";

echo "POST:<br/>";
echo print_r($_POST, true);
echo "<br/><br/>";

echo "SESSION:<br/>";
echo print_r($_SESSION, true);
echo "<br/><br/>";

echo "SERVER:<br/>";
echo print_r($_SERVER, true);
echo "<br/><br/>";
echo "</pre>";

?>