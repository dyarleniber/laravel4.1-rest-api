<?php

class Task extends Eloquent
{
	const PRIORITY_1 = 1;
	const PRIORITY_2 = 2;
	const PRIORITY_3 = 3;
	const PRIORITY_4 = 4;
	const PRIORITY_5 = 5;

	protected $table = 'tasks';

	protected $fillable = array('title', 'description', 'priority');

	protected $guarded = array('id');

	protected $hidden = array('created_at', 'updated_at');
	
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
