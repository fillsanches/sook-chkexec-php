<?php
//exemple file
echo 'File 4 has been required<br>';
require_once $_SERVER['DOCUMENT_ROOT'] . '/file3.php';












if (2 === 2) {
    echo "Something happened in " . $execution->execution(__LINE__)->percent() . "%<br>After execution the total of " . $execution->execution(__LINE__)->linesLoaded() . " lines<br>";
}

$execution->registerFinal(__FILE__, __LINE__);