<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class RCatalogueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct() {}

	//////////////////////////////////////////////////////
	//////////////////show related books//////////////////
	/////////////////////////////////////////////////////
	public function showRelatedBooks($topic){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'There is no books in store.']);
		}
		$book_detail;
		$json_data;
		$flag = false;
		$count = -1;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$book_detail[$i] = explode(",",$books[$i]);
			if ($book_detail[$i][3] == $topic){
				$count++;			
				$flag = true;
				$json_data[$count]['Title']=$book_detail[$i][0];
				$json_data[$count]['ID'] = $book_detail[$i][4];
			}
		}
		if (!$flag){
			return response()->json(['Message' => 'Try another topic.']);
		}
		return response()->json($json_data);
	}

	//////////////////////////////////////////////////////
	////////////////////show this book////////////////////
	/////////////////////////////////////////////////////
   	public function showOneBook($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'There is no books in store.']);
		}
		$book_details;
		$json_data;
		$flag = false;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$book_details[$i] = explode(",",$books[$i]);
			if ($book_details[$i][4] == $id){
				$flag = true;
				$json_data['Title'] = $book_details[$i][0];
				$json_data['Count'] = $book_details[$i][1];
				$json_data['Price'] = $book_details[$i][2];
				$json_data['Topic'] = $book_details[$i][3];
				$json_data['ID'] = $book_details[$i][4];
			}
		}
		if (!$flag){
			return response()->json(['Message' => 'Wrong ID , check it please.']);
		}
		return response()->json($json_data);
	}

	//////////////////////////////////////////////////////
	////////////////////check this book///////////////////
	/////////////////////////////////////////////////////
	public function checkStore($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'No']);
		}
		$book_details;
		$flag = false;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$book_details[$i] = explode(",",$books[$i]);
			if ($book_details[$i][4] == $id){
				if ($book_details[$i][1] < 1){
					return response()->json(['Message' => 'Zero']);
				}
				$book_details[$i][1]--;
				$book_details[$i][1] =$book_details[$i][1].""; 
				$flag=true;
			}
		}
		if(!$flag){
			return response()->json(['Message' => 'Wrong']);
		}
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){ 
			$books[$i] = implode(",",$book_details[$i]);
		}
		$content = implode("\n",$books);
		$file->put(__DIR__.'/../../books.txt' , $content,false);
		return response()->json(['Message' => 'Done']);
     }

	//////////////////////////////////////////////////////
	////////////////////buy this book///////////////////
	/////////////////////////////////////////////////////
	public function buyBook($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'There is no books in store.']);
		}
		$book_details;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$book_details[$i] = explode(",",$books[$i]);
			if ($book_details[$i][4] == $id){
				if ($book_details[$i][1] <= 0){
					return response()->json(["Message"=>'Buy Failed.']);
				}
				break;
			}
		}
		return response()->json(['Message' => 'Buy done successfuly.']);
}
    //
}