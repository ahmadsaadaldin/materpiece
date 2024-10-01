<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['insurance_number','medical_history','date_of_birth','user_id','doctor_id'] ;
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
public function billings()
{
    return $this->hasMany(Billing::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
