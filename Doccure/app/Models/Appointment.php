<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_date','appointment_time','status','patient_id','doctor_id','notes'];
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
public function billings()
{
    return $this->hasMany(Billing::class);
}


}
