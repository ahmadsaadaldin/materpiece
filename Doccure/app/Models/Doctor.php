<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'specialization', 'years_of_experience', 'description', 
        'gender', 'date_of_birth', 'clinic_name', 'clinic_address', 
        'clinic_images', 'address_line_1', 'address_line_2', 'city', 
        'state', 'country', 'postal_code', 'biography', 'services', 
        'education', 'experience', 'image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'doctor_patient');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(){
        return $this->hasMany(MedicalRecord::class);
    }

    public function secretary(){
        return $this->hasOne(Secretary::class);
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
