<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatuses()
    {
        return [
            0 => __('Neatsakyta'),
            1 => __('Atsakyta'),
            2 => __('Išspresta'),
            3 => __('Uždaryta')
        ];
    }

    public function getStatus()
    {
        return $this->getStatuses()[$this->status];
    }
}
