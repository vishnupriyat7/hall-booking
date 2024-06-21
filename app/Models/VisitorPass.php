<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorPass extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'visitor_passes';

    public const PURPOSE_SELECT = [
        'personal'   => 'Personal',
        'official'   => 'Official',
        'conference' => 'Conference',
    ];

    protected $dates = [
        'pass_valid_from',
        'pass_valid_upto',
        'issued_date',
        'date_of_visit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'number',
        'person_id',
        'pass_valid_from',
        'pass_valid_upto',
        'issued_date',
        'date_of_visit',
        'purpose',
        'visiting_office',
        'recommending_office',
        'visiting_office_category_id',
        'recommending_office_category_id',
        'mobile',
        'id_type',
        'id_detail',
        'address',
        'country',
        'state',
        'district',
        'post_office',
        'pincode',
        'print_count',
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

    // public function getPassValidFromAttribute($value)
    // {
    //     return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    // }

    // public function setPassValidFromAttribute($value)
    // {
    //     $this->attributes['pass_valid_from'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    // }

    // public function getPassValidUptoAttribute($value)
    // {
    //     return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    // }

    // public function setPassValidUptoAttribute($value)
    // {
    //     $this->attributes['pass_valid_upto'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    // }

    // public function getIssuedDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setIssuedDateAttribute($value)
    // {
    //     $this->attributes['issued_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getDateOfVisitAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setDateOfVisitAttribute($value)
    // {
    //     $this->attributes['date_of_visit'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function visiting_office_category()
    {
        return $this->belongsTo(VisitingOfficeCategory::class, 'visiting_office_category_id');
    }

    public function recommending_office_category()
    {
        return $this->belongsTo(RecommendingOfficeCategory::class, 'recommending_office_category_id');
    }
}
