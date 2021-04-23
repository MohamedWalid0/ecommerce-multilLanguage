<?php

namespace App\Support\Storage;

use App\Support\Storage\Contracts\StorageInterface;
use Illuminate\Support\Facades\Session;

// use Session;

class SessionStorage implements StorageInterface
{
	/**
	 * The basket beeing used.
	 *
	 * @var String
	 */
	protected $basket;

	/**
	 * Set the basket name that should be used.
	 *
	 * @param String $basket
	 */
	public function __construct($basket = 'default')
	{
		if(! Session::has($basket)) {
			Session::put($basket, []);
		}

		$this->basket = $basket;
	}

	/**
	 * Put the product inside the basket.
	 *
	 * @param Integer $index
	 * @param array   $value
	 */
	public function set($index, $value)
	{
		return Session::put("{$this->basket}.{$index}", $value);
	}

    /**
     * Get the product from the basket.
     *
     * @param $index
     *
     * @return mixed|null
     */
	public function get($index)
	{
		if (! $this->exists($index)) {
			return null;
		}

		return Session::get("{$this->basket}.{$index}");
	}

    /**
     * Check if the product index exists in the basket.
     *
     * @param $index
     *
     * @return mixed
     */
	public function exists($index)
	{
		return Session::has("{$this->basket}.{$index}");
	}

	/**
	 * Get all products inside the basket.
	 *
	 */
	public function all()
	{
		return Session::get("{$this->basket}");
	}

	/**
	 * Remove a product from the basket.
	 *
	 * @param Integer $index
	 */
	public function remove($index)
	{
		if ($this->exists($index)) {
			Session::forget("{$this->basket}.{$index}");
		}
	}

	/**
	 * Clear the entire basket.
	 */
	public function clear()
	{
		Session::forget($this->basket);
	}
}
