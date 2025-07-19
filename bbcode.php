<?php
$zinute = preg_replace('/\[b\](.*?)\[\/b\]/i','<b>\\1</b>',$zinute);
$zinute = preg_replace('/\[i\](.*?)\[\/i\]/i','<i>\\1</i>',$zinute);
$zinute = preg_replace('/\[u\](.*?)\[\/u\]/i','<u>\\1</u>',$zinute);
$zinute = preg_replace('/\[s\](.*?)\[\/s\]/i','<strike>\\1</strike>',$zinute);

?>