<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupPerson extends Model
{
    use HasFactory;

    public $table = 'group_people';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sl_no',
        'name',
        'age',
        'gender',
        'gallery_pass_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const GENDER_SELECT = [
        'male'        => 'male',
        'female'      => 'female',
        'transgender' => 'transgender',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function gallery_pass()
    {
        return $this->belongsTo(GalleryPass::class, 'gallery_pass_id');
    }
}
