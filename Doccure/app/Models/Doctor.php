<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'years_of_experience', 'specialization', 'user_id','image','description'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function patients(){
        return $this->hasMany(Patient::class);
}
public function appointments(){
    return $this->hasMany(Appointment::class);
}
public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
public function secretary()
{
    return $this->hasOne(Secretary::class);
}
}
