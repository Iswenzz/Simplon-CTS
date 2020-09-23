<?php

/**
 * Deserialize an hashmap to a specific class.
 */
class Deserializer
{
	private string $className;
	private $data;
	private ReflectionClass $reflection;
	private $instance;

	/**
	 * Deserializer constructor.
	 * @param string $className - The class name.
	 * @param $data - The data hashmap to deserialize.
	 */
	public function __construct(string $className, $data)
	{
		$this->className = $className;
		$this->data = $data;
	}

	/**
	 * Deserialize the data to a new instance.
	 * @return object|null - The new instance.
	 */
	public function deserialize()
	{
		try
		{
			$this->reflection = new ReflectionClass($this->className);
			$this->instance = $this->reflection->newInstance();
			foreach ($this->data as $key => $value)
			{
				$prop = $this->reflection->getProperty($key);
				$prop->setAccessible(true);
				$prop->setValue($this->instance, $value);
			}
			return $this->instance;
		}
		catch (ReflectionException $e)
		{
			print_r($e->getMessage());
		}
		return null;
	}
}
