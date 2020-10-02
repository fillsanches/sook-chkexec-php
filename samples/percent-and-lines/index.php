<?php
//exemple file
require_once 'Autoload.php';

$execution = new Chkexec('execution001');

/*
Place here all the files that will compose the execution one
*/

$files = array(
    __DIR__.'/index.php',
    __DIR__.'/file2.php',
    __DIR__.'/file3.php',
    __DIR__.'/subdirectory/file4.php'
);

$execution->addFileToCheck($files);

echo "Starting execution of " . $execution->listFilesToCheck(true)  . "<br>"; //pass null or false to array
echo "All files add up to: " . $execution->linesToLoad() . " lines<br>";

/*
Also check that there are no files required or included in the execution flow
that are not in the mapped_files array.
You can check the mapped files with listFilesToCheck() method
*/
require_once 'file2.php';

if (2 === 2) {
    echo "Something happened in " . $execution->execution(__LINE__)->percent() . "%<br>After execution the total of " . $execution->execution(__LINE__)->linesLoaded() . " lines<br>";
}

if (2 === 2) {
    echo "Something happened in " . $execution->execution(__LINE__)->percent() . "%<br>After execution the total of " . $execution->execution(__LINE__)->linesLoaded() . " lines<br>";
}

$execution->registerFinal(__FILE__, __LINE__); echo "All files resulted in: " . $execution->execution()->linesLoaded() . " lines<br>Loaded " . $execution->execution()->percent() . "%";