<?php
$title = $_POST['title'];
$content = $_POST['content'];
updateData("tbMain", $title+","+$content, 1) 
echo "Thank You!" . " -" . "<a href='form.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
?>
