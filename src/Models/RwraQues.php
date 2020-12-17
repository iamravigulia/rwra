<?php
namespace Edgewizz\Rwra\Models;

use Illuminate\Database\Eloquent\Model;

class RwraQues extends Model{
    public function answers(){
        return $this->hasMany('Edgewizz\Rwra\Models\RwraAns', 'question_id');
    }
    protected $table = 'fmt_rwra_ques';
}