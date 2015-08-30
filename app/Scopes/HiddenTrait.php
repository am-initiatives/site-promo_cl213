<?php

namespace App\Scopes;

trait HiddenTrait {

	/**
	 * Boot the scope.
	 * 
	 * @return void
	 */
	public static function bootHiddenTrait()
	{
		static::addGlobalScope(new HiddenScope);
	}

	/**
	 * Get the name of the column for applying the scope.
	 * 
	 * @return string
	 */
	public function getHiddenColumn()
	{
		return defined('static::HIDDEN_COLUMN') ? static::HIDDEN_COLUMN : 'hidden';
	}

	/**
	 * Get the fully qualified column name for applying the scope.
	 * 
	 * @return string
	 */
	public function getQualifiedHiddenColumn()
	{
		return $this->getTable().'.'.$this->getHiddenColumn();
	}

	/**
	 * Get the query builder without the scope applied.
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function withHidden()
	{
		return with(new static)->newQueryWithoutScope(new HiddenScope);
	}
}
