<?php

class Product
{
	/**
	 * @var string
	 */
	private $filename;

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $model;

	/**
	 * @var float
	 */
	private $price;

	/**
	 * Use this field carefully. I was to lazy and did not want to waste time to write a proper method to get the relative
	 * path with help of the filename.
	 * @var string|null
	 */
	private $currentRelativePath;

	/**
	 * @param string $filename
	 * @param string $id
	 * @param string $name
	 * @param string $model
	 * @param float $price
	 * @param string|null $currentRelativePath
	 */
	public function __construct($filename, $id, $name, $model, $price, $currentRelativePath = null)
	{
		$this->filename = $filename;
		$this->id = $id;
		$this->name = $name;
		$this->model = $model;
		$this->price = $price;
		$this->currentRelativePath = $currentRelativePath;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * @param string $filename
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * @param string $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * @return string
	 */
	public function getCurrentRelativePath()
	{
		return $this->currentRelativePath;
	}

	/**
	 * @param string $currentRelativePath
	 */
	public function setCurrentRelativePath($currentRelativePath)
	{
		$this->currentRelativePath = $currentRelativePath;
	}
}