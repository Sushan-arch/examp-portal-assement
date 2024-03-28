<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'expiry_date'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'invitations')->withPivot('token')->withTimestamps();
    }

    public function scopeActive()
    {
        return $this->where('expiry_date', '>=', Carbon::now());
    }
}
