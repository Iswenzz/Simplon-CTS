<?php
require_once __DIR__ . "/../model/Model.php";

interface DAO
{
	/**
	 * Get the DAO class name.
	 */
	function getClassName(): string;

	/**
	 * Get a specific model.
	 * @param $key - The primary key.
	 */
	function get($key): ?Model;

	/**
	 * Get all model rows.
	 * @return array
	 */
	function getAll(): array;

	/**
	 * Update the model row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	function update($model): bool;

	/**
	 * Delete the model row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	function delete(Model $model): bool;

	/**
	 * Add the model row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	function add(Model $model): bool;
}
