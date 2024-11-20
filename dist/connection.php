<?php
$db = mysqli_connect('localhost', 'root', '') or
        die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'expense_tracker_db') or die(mysqli_error($db));
?>