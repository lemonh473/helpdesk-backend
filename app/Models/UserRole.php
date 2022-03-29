<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRoles()
    {
        return [
            1 => __('Darbuotojas'),
            2 => __('Naudotojas')
        ];
    }

    public function getRoleName()
    {
        return $this->getRoles()[$this->role];
    }
}