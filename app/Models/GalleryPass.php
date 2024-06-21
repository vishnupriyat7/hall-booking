<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPass extends Model
{
    use HasFactory;

    public $table = 'gallery_passes';

    protected $dates = [
        'issued_date',
        'date_of_visit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'number',
        'person_id',
        'issued_date',
        'date_of_visit',
        'guide_id',
        'print_count',
        'id_type',
        'id_detail',
        'address',
        'country',
        'state',
        'district',
        'post_office',
        'pincode',
        'photo',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function getIssuedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setIssuedDateAttribute($value)
    {
        $this->attributes['issued_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateOfVisitAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfVisitAttribute($value)
    {
        $this->attributes['date_of_visit'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function guide()
    {
        return $this->belongsTo(GuidingOfficer::class, 'guide_id');
    }
}
