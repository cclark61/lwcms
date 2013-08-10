<?php
//***************************************************************************
/**
* LWCMS (Lightweight Content Mangement System)
*
* @package		LWCMS
* @author 		Christian J. Clark
* @copyright	Copyright (c) Christian J. Clark
* @license		http://www.gnu.org/licenses/gpl-2.0.txt
* @link			http://www.emonlade.net/lwcms/
**/
//***************************************************************************

//************************************************************
// Install Files Function
//************************************************************
function install_files($source_dir, $dest_dir)
{
	$num_errors = 0;
	$dir_list = scandir($source_dir);
	if ($dir_list) {
		foreach ($dir_list as $item) {
			if ($item == "." || $item == ".." || substr($item, 0, 1) == ".") { continue; }
			$src_file = $source_dir . "/" . $item;
			$dest_file = $dest_dir . "/" . $item;
			if (is_dir($src_file)) { continue; }
			$status = copy($src_file, $dest_file);
			$num_errors += ($status) ? (0) : (1);
		}
	}
	else {
		$num_errors++;
	}
	return $num_errors;
}

//************************************************************
// Recursively Remove Directory
//************************************************************
function rrmdir($dir)
{
	$num_errors = 0;
	if (is_dir($dir)) {
    	$objects = scandir($dir);
    	foreach ($objects as $object) {
	    	if ($object != "." && $object != "..") {
	    		$full_object = "{$dir}/{$object}";
		    	if (is_dir($full_object)) {
		    		$num_errors += rrmdir($full_object);
		    	}
		    	else {
		    		if (!unlink($full_object)) { $num_errors++; }
		    	}
		    }
		}

		reset($objects);
		if (!rmdir($dir)) { $num_errors++; }
	}

	return $num_errors;
}

//************************************************************
// Check Uninstall Directories
//************************************************************
function check_uninstall_dirs($phrase)
{
	$num_errors = 0;
	$uninstall_dirs = array(
		"{$_SESSION['file_path']}/modules/{$phrase}"
	);

	//--------------------------------------------------------
	// Create Third Party Directories if they do not exist
	//--------------------------------------------------------
	foreach ($uninstall_dirs as $i) {
		if (is_dir($i) && !is_writable($i)) {
			$num_errors++;
		}
	}

	return $num_errors;
}

//************************************************************
// Check Module Package
//************************************************************
function check_module_package()
{
	 if (isset($_FILES['datafile'])) {
		 if ($_FILES["datafile"]["name"] == '') {
			 add_warn_message('Invalid module package.');
		 }
		 else if ($_FILES["datafile"]['type'] != 'application/zip') {
			 add_warn_message('Invalid module package. Required format is a ZIP archive file.');
		 }
		 else {
			$zip = new ZipArchive();
			if ($zip->open($_FILES["datafile"]["tmp_name"]) === true) {

				//----------------------------------------------------------
				// Loop through all files in ZIP Archive
				//----------------------------------------------------------
				$curr_phrase = '';
				for ($i = 0; $i < $zip->numFiles; $i++) {
					$filename = $zip->getNameIndex($i);

					//----------------------------------------------------------
					// Skip if "__MACOSX" or starts with "."
					//----------------------------------------------------------
					if (substr($filename, 0, 8) == '__MACOSX' || substr($filename, 0, 1) == '.') { continue; }
					//print $filename . "<br/>\n";

					//----------------------------------------------------------
					// Locate First "/" to determine root folder
					//----------------------------------------------------------
					if ($pos = strpos($filename, '/')) {
						$tmp_phrase = substr($filename, 0, $pos);
						//print $tmp_phrase . "<br/>\n";

						//----------------------------------------------------------
						// Is this a new Folder?
						//----------------------------------------------------------
						if ($curr_phrase != $tmp_phrase) {
							$curr_phrase = $tmp_phrase;
							$mod_info_index = $zip->locateName("{$curr_phrase}/module_info/module_info.php");

							//----------------------------------------------------------
							// Does the Module Info File exist?
							//----------------------------------------------------------
							if ($mod_info_index) {
								$tmp = tmpfile();
								$metadata = stream_get_meta_data($tmp);
								file_put_contents($metadata['uri'], $zip->getFromIndex($mod_info_index));
								include($metadata['uri']);

								//----------------------------------------------------------
								// Was the Module Info variable "$module" set?
								//----------------------------------------------------------
								if (isset($module)) {
									$req_indices = array('phrase', 'mod_desc', 'image', 'mod_dir', 'version');
									$failed_reqs = 0;
									foreach ($req_indices as $ri) {
										if (!isset($module[$ri])) {
											add_warn_message("Module information setting '{$ri}' is not set, but is required. Please fix and try again.");
											$failed_reqs++;
										}
									}

									//----------------------------------------------------------
									// Missing Required Parameters?
									//----------------------------------------------------------
									if ($failed_reqs) {
										$zip->close();
										return false;
									}

									//----------------------------------------------------------
									// Phrase Mismatch?
									//----------------------------------------------------------
									if ($tmp_phrase != $module['phrase']) {
										add_warn_message("Phrase mismatch between settings and actual folder name.");
										$zip->close();
										return false;
									}

									$zip->close();
									return $module;
								}
							}
						}
					}
				}
			}
			else {
				add_warn_message('Unable to unpack module package.');
			}
		 }
	 }
	 else {
		 add_warn_message('Unable to locate the uploaded module package.');
	 }
	 
	 return false;
}

?>
