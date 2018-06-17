<?php

class Task extends Eloquent
{
	const PRIORITY_1 = 1;
	const PRIORITY_2 = 2;
	const PRIORITY_3 = 3;
	const PRIORITY_4 = 4;
	const PRIORITY_5 = 5;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden;

	public static function getPriorityLabel($priority)
	{
		switch ($priority) {
			case self::PRIORITY_1:
				return 'Maximum priority';
				break;
			case self::PRIORITY_2:
				return 'High priority';
				break;
			case self::PRIORITY_3:
				return 'Medium priority';
				break;
			case self::PRIORITY_4:
				return 'Low priority';
				break;
			case self::PRIORITY_5:
				return 'Minimum priority';
				break;
			default:
				return null;
				break;
		}
	}
}
