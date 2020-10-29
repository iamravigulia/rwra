<?php

namespace edgewizz\fillup\Controllers;
use App\Http\Controllers\Controller;
use Edgewizz\Fillup\Models\FillupAns;
use Edgewizz\Fillup\Models\FillupQues;
use Illuminate\Http\Request;

class FillupController extends Controller
{
    //
    public function test(){
        dd('hello');
    }
    public function store(Request $request){
        // dd('got here');
        $fillupQues = new FillupQues();
        $fillupQues->question = $request->question;
        $fillupQues->save();
        $fillupAns1 = new FillupAns();
        $fillupAns1->question_id = $fillupQues->id;
        $fillupAns1->answer = $request->answer;
        $fillupAns1->save();
        return back();
    }
    public function edit($id, Request $request){
        
    }
}
