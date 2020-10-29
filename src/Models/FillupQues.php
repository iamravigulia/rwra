<?php
namespace Edgewizz\Fillup\Models;

use Illuminate\Database\Eloquent\Model;

class FillupQues extends Model{
    public function answer(){
        return $this->hasOne('Edgewizz\Fillup\Models\FillupAns', 'question_id');
    }
    protected $table = 'fmt_fillup_ques';
}