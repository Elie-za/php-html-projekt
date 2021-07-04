<?php

class Customer
{
	/**
	 * @var string
	 */
	private $nachname;

	/**
	 * @var string
	 */
	private $vorname;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $street;

	/**
	 * @var int
	 */
	private $houseNumber;

	/**
	 * @var int
	 */
	private $zipCode;

	/**
	 * @var string
	 */
	private $place;

	/**
	 * @var int
	 */
	private $age;

	/**
	 * @param string $nachname
	 * @param string $vorname
	 * @param string $password
	 * @param string $email
	 * @param string $street
	 * @param int $houseNumber
	 * @param int $zipCode
	 * @param string $place
	 * @param int $age
	 */
	public function __construct($nachname, $vorname, $password, $email, $street, $houseNumber, $zipCode, $place, $age)
	{
		$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 5]);
		if (!is_string($hashedPassword)) {
			die('Something went wrong :(');
		}
		$this->nachname = $nachname;
		$this->vorname = $vorname;
		$this->password = $hashedPassword;
		$this->email = $email;
		$this->street = $street;
		$this->houseNumber = $houseNumber;
		$this->zipCode = $zipCode;
		$this->place = $place;
		$this->age = $age;
	}

	/**
	 * @param string $password
	 * @return bool
	 */
	public function verifyPassword($password)
	{
		return password_verify($password, $this->password);
	}

	/**
	 * Returns false if customer already exists. Otherwise attempts to write data in customer data file and returns true.
	 * @return bool
	 */
	public function writeDataIntoFile()
	{
		$existingCustomerData = getSearchedDataFromFile($this->email, '../data/customer_data.txt');
		if (!empty($existingCustomerData)) {
			return false;
		}
		$fields = get_object_vars($this);
		foreach ($fields as $key => $field) {
			if ($field === null) {
				$fields[$key] = 'NULL';
			}
		}
		$dataString = implode('|', $fields);
		file_put_contents('../data/customer_data.txt', $dataString . PHP_EOL, FILE_APPEND);
		return true;
	}

	/**
	 * @return string
	 */
	public function getNachname()
	{
		return $this->nachname;
	}

	/**
	 * @return string
	 */
	public function getVorname()
	{
		return $this->vorname;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @return int
	 */
	public function getHouseNumber()
	{
		return $this->houseNumber;
	}

	/**
	 * @return int
	 */
	public function getZipCode()
	{
		return $this->zipCode;
	}

	/**
	 * @return string
	 */
	public function getPlace()
	{
		return $this->place;
	}

	/**
	 * @return int
	 */
	public function getAge()
	{
		return $this->age;
	}
}
