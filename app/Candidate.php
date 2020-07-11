<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
	protected $dateFormat = 'U';

	protected $fillable = ['first_name', 'last_name', 'email', 'contact_number', 'gender', 'specialization', 'work_ex_year', 'candidate_dob', 'address', 'resume', 'user_id'];

	protected $casts = [
    	'candidate_dob'  => 'date:Y-m-d',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}