<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['insurance_number', 'medical_history', 'date_of_birth', 'user_id'];

    public function doctors(){
        return $this->belongsToMany(Doctor::class, 'doctor_patient');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(){
        return $this->hasMany(MedicalRecord::class);
    }

    public function billings(){
        return $this->hasMany(Billing::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}

}
