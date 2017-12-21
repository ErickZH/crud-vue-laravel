<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
	protected $table = 'departures';

	public $timestamps = false;

    protected $fillable = ['title'];
}
