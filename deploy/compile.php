<?php 


// set PHP timeout
ini_set('max_execution_time', 1600);

// turn off errors
error_reporting(0);
ini_set("display_errors", 0);

$sharedfoldername = "CRYSVT-pedi-shared"; // change this to the shared folder name

// some text styling
$red = "\033[01;31m";
$redclose = "\033[0m";
$green = "\033[01;32m";
$greenclose = "\033[0m";
$bold = "\033[1m";
$boldclose = "\033[0m";

// put arguments into a loop and check the options
for ($i = 0; $i < count($argv); $i++) {
    switch ($argv[$i]) {
        //nozip = don't automatically zip up the slides
        case 'nozip':
            $nozip = true;
            break;
    }
}

// keep track of critical issues
$criticals = 0;

echo "\n".$bold."Starting process".$boldclose."\n\n";

// test for not a key message/slide
function isKeyMessage($slide){
	switch($slide){
		case '.':
			return false;
		case '..':
			return false;
		case '.DS_Store':
			return false;
		default:
			return true;
	}
}

// removes files and non-empty directories
function rrmdir($dir) {
	if (is_dir($dir)) {
		$files = scandir($dir);
		foreach ($files as $file)
		if ($file != "." && $file != "..") rrmdir("$dir/$file");
		rmdir($dir);
	}
	else if (file_exists($dir)) unlink($dir);
} 

// delete previous export
if (is_dir("updated_slides")) {
    rrmdir("updated_slides");
	rrmdir("zip_files");
}

// create the new directory for compiled key messages
exec("mkdir updated_slides && cd updated_slides");

exec("cp -R ../slides/* updated_slides/");
echo("Renaming shared folder to ".$sharedfoldername."\n\n");
passthru("mv updated_slides/shared updated_slides/".$sharedfoldername);

if (!chdir("updated_slides")) {
    echo $red." ERROR: The folder updated_slides does not exist.".$redclose."\n\n";
    $criticals++;
}

// starting point for processing slides
$parent_dir = getcwd();

// get new list of slides w/o any .zips
$slides = scandir($parent_dir);
$i = 0;

// loop through key messages and perform operations on them
while ($i < count($slides)) {
    if (isKeyMessage($slides[$i])) {
        echo("\n".$bold."Key message: ".$slides[$i].$boldclose."\n");
		
		// change directory to the current key message
		chdir($slides[$i]);

			// check for any html files in the slide
			$htmlfiles = glob("*.html");
			if (!$htmlfiles){
				$htmlfiles = glob("*/*.html");
			}

			// update the link paths for shared items
			foreach($htmlfiles as $htmlfile){
				echo "HTML file found: " . $htmlfile . "\n";

				$html = file_get_contents($htmlfile);
				$html = str_replace("../shared", "./shared", $html);
				$html = file_put_contents($htmlfile, $html);

				if ($html) {
					echo("Shared file paths updated\n");
				} else {
					$errormsg = $red."Shared file paths not updated".$redclose."\n";
					echo($errormsg);
					$criticals++;
				}
			}

		// change directory back to the root/start
		chdir($parent_dir);
    }
    $i++;
}

// if no critical issues, then zip all key messages
if (!$nozip){
	if ($criticals < 1) {
		exec("mkdir ../zip_files");
		$i = 0;
		while ($i < count($slides)) {
			if (isKeyMessage($slides[$i])) {
				shell_exec("ditto -c -k --sequesterRsrc ".$slides[$i]." ../zip_files/".$slides[$i].".zip");
			}
			$i++;
		}
		chdir('../zip_files');
		$zip_dir = getcwd();
	}
}

// create space
echo "\n\n";

// show results
if ($criticals > 0) {
    echo $red." There are ".$criticals." critical issues. Zip files have not been created.".$redclose."\n\n";
} else {
    echo $green."Process completed successfully.".$greenclose."\n\n";
	echo($bold."You can find your compiled slides here:".$boldclose."\n".$parent_dir."\n\n");
	if (!$nozip){
		echo($bold."You can find your zip files here:".$boldclose."\n".$zip_dir."\n\n");
	}
    echo "Have a nice day. :)\n\n";
}


?>