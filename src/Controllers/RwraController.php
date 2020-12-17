<?php

namespace edgewizz\rwra\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Edgewizz\Rwra\Models\RwraQues;
use Illuminate\Http\Request;

class RwraController extends Controller
{
    //
    public function test(){
        dd('hello rswa');
    }
    public function store(Request $request){
        $Q = new RwraQues();
        $Q->question = $request->question;
        $Q->difficulty_level_id = $request->difficulty_level_id;
        if($request->question_media){
            $ques_media = new Media();
            $request->question_media->storeAs('public/answers', time().$request->question_media->getClientOriginalName());
            $ques_media->url = 'answers/'.time().$request->question_media->getClientOriginalName();
            $ques_media->save();
            $Q->media_id = $ques_media->id;
        }
        $Q->save();
        if($request->problem_set_id && $request->format_type_id){
            $pbq = new ProblemSetQues();
            $pbq->problem_set_id = $request->problem_set_id;
            $pbq->question_id = $Q->id;
            $pbq->format_type_id = $request->format_type_id;
            $pbq->save();
        }
        return back();
    }
    public function update($id, Request $request){
        $Q = RwraQues::findOrFail($id);
        $Q->question = $request->question;
        $Q->difficulty_level_id = $request->difficulty_level_id;
        if($request->question_media){
            $ques_media = new Media();
            $request->question_media->storeAs('public/answers', time().$request->question_media->getClientOriginalName());
            $ques_media->url = 'answers/'.time().$request->question_media->getClientOriginalName();
            $ques_media->save();
            $Q->media_id = $ques_media->id;
        }
        $Q->save();
        return back();
    }
    public function inactive($id){
        $f = RwraQues::where('id', $id)->first();
        $f->active = '0';
        $f->save();
        return back();
    }
    public function active($id){
        $f = RwraQues::where('id', $id)->first();
        $f->active = '1';
        $f->save();
        return back();
    }
    public function imagecsv($question_image, $images){
        foreach($images as $valueImage){
            $uploadImage = explode(".", $valueImage->getClientOriginalName());
            if($uploadImage[0] == $question_image){
                // dd($valueImage);
                $media = new Media();
                $valueImage->storeAs('public/question_images', time() . $valueImage->getClientOriginalName());
                $media->url = 'question_images/' . time() . $valueImage->getClientOriginalName();
                $media->save();
                return $media->id;
            }
        }
    }
    public function csv_upload(Request $request){

        $file = $request->file('file');
        $audio = $request->file('audio');
        // dd($file);
        // File Details
        $filename = time() . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        // Valid File Extensions
        $valid_extension = array("csv");
        // 2MB in Bytes
        $maxFileSize = 2097152;
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                $location = 'uploads';
                // Upload file
                $file->move($location, $filename);
                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);
                // Reading file
                $file = fopen($filepath, "r");
                $importData_arr = array();
                $i = 0;
                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    $insertData = array(
                        "question" => $importData[1],
                        "question_media" => $importData[2],
                        "level" => $importData[3],
                    );
                    // var_dump($insertData['answer1']);
                    /*  */
                    if ($insertData['question']) {
                        $fill_Q = new RwraQues();
                        $fill_Q->question = $insertData['question'];
                        if(!empty($insertData['level'])){
                            if($insertData['level'] == 'easy'){
                                $fill_Q->difficulty_level_id = 1;
                            }else if($insertData['level'] == 'medium'){
                                $fill_Q->difficulty_level_id = 2;
                            }else if($insertData['level'] == 'hard'){
                                $fill_Q->difficulty_level_id = 3;
                            }
                        }
                        if ($insertData['question_media']) {
                            if (!empty($insertData['question_media']) && $insertData['question_media'] != '') {
                                $media_id = $this->imagecsv($insertData['question_media'], $audio);
                                $fill_Q->media_id = $media_id;
                            }
                            // $m = new Media();
                            // $m->url = $insertData['question_media'];
                            // $m->save();
                            // $fill_Q->media_id = $m->id;
                        }
                        $fill_Q->save();
                        if($request->problem_set_id && $request->format_type_id){
                            $pbq = new ProblemSetQues();
                            $pbq->problem_set_id = $request->problem_set_id;
                            $pbq->question_id = $fill_Q->id;
                            $pbq->format_type_id = $request->format_type_id;
                            $pbq->save();
                        }
                    }
                    /*  */
                }
                // Session::flash('message', 'Import Successful.');
            } else {
                // Session::flash('message', 'File too large. File must be less than 2MB.');
            }
        } else {
            // Session::flash('message', 'Invalid File Extension.');
        }
        return back();
    }
}
