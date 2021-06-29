<?php
# liest eine CSV Datei ein und git ein assosiatives Array zurück
# $fileName ist der Pfad der Datei
function csv_to_array($fileName)
{
    $keys = [];
    $tableArray = [];

    if (file_exists($fileName) && ($csvFile = fopen($fileName, "r")) !== false) {
        $i = 0;
        while (($row = fgetcsv($csvFile, 0, ",")) !== false) {
            if ($i === 0) {
                foreach ($row as $item) {
                    $keys[] = $item;
                }
            } else {
                $number = count($row);
                $rowClean = [];
                for ($i = 0; $i < $number; $i++) {
                    $rowClean[$keys[$i]] = trim($row[$i]);
                }
                $tableArray[] = $rowClean;
            }
            $i++;
        }
    }

    return $tableArray;
}

/**
 * Expects an one dimensional array to iterate over an sanitize the value. The output array should contain the same keys
 * as the input array.
 * @param array $userInput The array to sanitize.
 * @param array $emailKeys Keys for values containing an mail address.
 * @return array
 */
function sanitizeUserInput($userInput, $emailKeys = [])
{
	$sanitizedUserInput = [];
	foreach ($emailKeys as $emailKey) {
		$sanitizedUserInput[$emailKey] = filter_var($userInput[$emailKey], FILTER_SANITIZE_EMAIL);
		unset($userInput[$emailKey]);
	}
	foreach ($userInput as $key => $input) {
		switch (gettype($input)) {
			case 'string':
				$sanitizedUserInput[$key] = filter_var(trim($input), FILTER_SANITIZE_STRING);
				break;
			case 'integer':
				$sanitizedUserInput[$key] = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
				break;
			default:
				break;
		}
	}
	return $sanitizedUserInput;
}
