<?php

/**
 * @param $searchValue
 * @param string $filePath
 * @return array|null
 */
function getSearchedDataFromFile($searchValue, $filePath)
{
	if (file_exists($filePath)) {
		$file = file($filePath);
		foreach ($file as $line) {
			$dataArray = (array)explode('|', $line);
			$isValueInData = in_array($searchValue, $dataArray);
			if ($isValueInData) {
				return $dataArray;
			}
		}
	}
	return null;
}

/**
 * @param array $searchValues
 * @param string $filePath
 * @return array
 */
function getMultipleSearchedDataFromFile($searchValues, $filePath)
{
	$data = [];
	if (file_exists($filePath)) {
		$file = file($filePath);
		foreach ($file as $line) {
			$lineData = (array)explode('|', $line);
			foreach ($searchValues as $searchValue) {
				if (in_array($searchValue, $lineData)) {
					$data[$searchValue] = $lineData;
				}
			}
		}
	}
	return $data;
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

function redirectToLastPage()
{
	$lastUrlArray = empty($_SERVER['HTTP_REFERER']) ? null : explode('/', $_SERVER['HTTP_REFERER']);
	$lastUrlArrayLength = count($lastUrlArray);
	if (!empty($lastUrlArray)) {
		header('Location: ../' . $lastUrlArray[$lastUrlArrayLength - 2] . '/' . $lastUrlArray[$lastUrlArrayLength - 1]);
	} else {
		header('Location: ../html/index.html');
	}
}
