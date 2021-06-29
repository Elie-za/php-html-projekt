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
