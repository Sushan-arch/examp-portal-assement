<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'question', 'options', 'correct_answer'];

    protected function casts()
    {
        return [
            'options' => 'json', // Cast options to JSON
        ];
    }

    public function questionnaire()
    {
        return $this->belongsToMany(Questionnaire::class);
    }
}
