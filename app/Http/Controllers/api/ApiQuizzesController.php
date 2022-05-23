<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class ApiQuizzesController extends Controller
{

     /*/**---------------------------------------------------------
      * *      get all Quizzes API
      *---------------------------------------------------------------**/ 


    public function allQuiz()
    {
        $quiz = new Quiz();
        return  response()->json(
            [
                "status" => 200,
                "data" => $quiz->allQuizzes()
            ]
        );
    }

      /*/**---------------------------------------------------------
      * *      Delete  Quizzes  By ID API
      *---------------------------------------------------------------**/ 


      public function deleteQuiz($id)
      {
          $quiz = new Quiz();
          $result = $quiz->delete_by_id($id);
          if($result)
          {
            return  response()->json(
                [
                    "status" => 404,
                    "message" =>  "Error-Quiz Id not found"
                ]
            );
          }
          else{
            return  response()->json(
                [
                    "status" => 200,
                    "message" =>  "Deleted Successfully"
                ]
            );
          }
         
      }

    
}
