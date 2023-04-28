<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Alumne;


class AlumneController extends Controller
{
   /*  public function __construct() {
		$this->authorizeResource(Schedule::class, 'schedule');

	} */
public $search = '';

   public function index(){


    return view('back.pages.home');
   }

   public function alumnes(Request $request){

    $users = Alumne::query();
    $users = $users->paginate(30);


    return view('back.pages.alumnes',compact('users'));
   }

   public function search(Request $request){
    // Get the search value from the request
    $search = $request->input('search');

    // Search in the title and body columns from the posts table
    $posts = Alumne::search('cognom1',$this->search)->paginate(30);

    // Return the search view with the resluts compacted
    //return view('search', compact('posts'));
    return view('back.pages.alumnes',compact('posts'));
}

/* public function insert(Request $request){
    $first_name = $request->input('first_name');
    $last_name = $request->input('last_name');
    $city_name = $request->input('city_name');
    $email = $request->input('email');
    $data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);
    DB::table('student_details')->insert($data);
    echo "Record inserted successfully.<br/>";
    echo '<a href = "/insert">Click Here</a> to go back.';
    } */

}
