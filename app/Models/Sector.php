<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Sector extends Model
{
    use SoftDeletes;

    public $table = 'sectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'segment_id',
        'name',
        'parent_id',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function construction()
    {
        return $this->belongsTo(Construction::class, 'construction_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }

    public function parent()
    {
        return $this->hasMany(Sector::class, 'parent_id');

    }

    public function children()
    {
        return $this->hasMany(Sector::class, 'parent_id')->with('parent')->orderBy('position');
    }

}
