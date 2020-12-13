<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

	public function buy($id){
		$url = 'http://192.168.1.5:8000/query/check/'.$id;
		$page = file_get_contents($url);
		$resp = response()->json(json_decode($page));
		$flag = json_decode($page)->Message;
		if ($flag == 'Zero'){
			return response()->json(['Message' => 'Zero copies of this book.']);
		}
		if ($flag == 'No'){
			return response()->json(['Message' => 'There is no books in the store.']);
		}
		if ($flag == 'Wrong'){
			return response()->json(['Message' => 'Wrong ID , please check it.']);
		}
		if ($flag == 'Done'){
		$url3 = 'http://192.168.1.5:8000/query/check/'.$id;
		$page3 = file_get_contents($url3);
		$url2 ='http://192.168.1.5:8000/update/buy/'.$id;
		$page2 = file_get_contents($url2);
	
		return response()->json(json_decode($page2));
		}
	}
    //
}