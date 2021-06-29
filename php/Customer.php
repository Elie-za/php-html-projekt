<?php
class Customer
{
	/**
	 * @var string
	 */
	private $username;

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
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @param string $street
	 * @param int $houseNumber
	 * @param int $zipCode
	 * @param string $place
	 * @param int $age
	 */
	public function __construct($username, $password, $email, $street, $houseNumber, $zipCode, $place, $age)
	{
		$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 5]);
		if (!is_string($hashedPassword)) {
			die('Something went wrong :(');
		}
		$this->username = $username;
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

	public function writeDataIntoFile()
	{
		$fields = get_object_vars($this);
		foreach ($fields as $key => $field) {
			if ($field === null) {
				$fields[$key] = '-';
			}
		}
		$dataString = implode('|', $fields);
		file_put_contents('../data/customer_data.txt', $dataString . PHP_EOL, FILE_APPEND);
	}
}
