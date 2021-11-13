<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, UuidTraits;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'marital_status',
        'name_next_of_kin',
        'phone_number_next_of_kin',
        'weight',
        'bias_against_alcohol',
        'hobbies',
        'work',
        'phone_number',
        'pin',
        'dob',
        'gender',
        'bio',
        'email',
        'is_submitted',
        'is_admin',
        'age',
        'height',
        'address',
        'home_address',
        'state_of_origin',
        'lga',
        'state_of_residence',
        'how_often',
        'medical_challenge',
        'video_url',
        'image_url',
        'status',
        'audition_location',
        'relationship_next_of_kin',
        'covid_19',
        'covid_19_reason',
        'code',
        'has_medical_challenge',
        'has_medical_allergies',
        'medical_allergies',
        'voting_enrol',
        'select_constant'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public function barcode()
    {
        return $this->hasOne(Barcode::class, 'user_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(NewVote::class, 'user_id', 'id');
    }
}
