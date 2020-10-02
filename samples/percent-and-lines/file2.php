<?php 
//exemple file
echo 'File 2 has been required<br>';
require_once 'subdirectory/file4.php';

if (2 === 2) {
    echo "Something happened in " . $execution->execution(__LINE__)->percent() . "%<br>After execution the total of " . $execution->execution(__LINE__)->linesLoaded() . " lines<br>";
}

//informe o final de um arquivo
$execution->registerFinal(__FILE__, __LINE__);