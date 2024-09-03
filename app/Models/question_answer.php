<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question_answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer' ,
        'true_answer' ,
        'question_id' ,
    ];

      public function getTrueAnswerAttribute ($value){
            $jsonData = '{"name":"Geeks","age":20,"email":"geeks@gmail.com"}';
            $decodedData = json_decode($value);
            return $decodedData;
      }
      public function getAnswerAttribute ($value){
            $jsonData = '{"name":"Geeks","age":20,"email":"geeks@gmail.com"}';
            $decodedData = json_decode($value);
            return $decodedData;
      }
}
