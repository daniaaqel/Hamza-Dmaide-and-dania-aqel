<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;// To use cache


class FrontendController extends Controller{

	public function __construct(){}
	
	public function getBooks($topic){
		$start = microtime(true);	// start time of query
		if (Cache::has($topic)){	// check if the item in cache
			$value = Cache::get($topic);	// get it from cache
			$endcache = microtime(true); // end time of query with cache
			//echo "cache:" . ($endcache - $start);
			//echo $value;
		
			$arr = $value;
			$str1 = explode ("[",$arr);
			if($str1[0]==null){

			$str = explode ("]",$arr);

			$ss = $str[0].',{'.'"cache":' .'"'.($endcache - $start).'"}]';
			}else{
				$str = explode ("]",$arr);

				$ss = '['.$str[0].',{'.'"cache":' .'"'.($endcache - $start).'"}]';
			}

		//echo $ss;
			return response()->json(json_decode($ss));
		}else{
		$url = '';
		$num = rand(1,4); // random load balancing algorithm
		if ($num < 3){
			$url = 'http://192.168.1.5:8000/query/booktopic/'.$topic;
		}
		else {
			$url = 'http://192.168.1.4:8000/query/booktopic/'.$topic;		
		}
	
		$page = file_get_contents($url); // get the topics from catalogue
		
		Cache::put($topic , $page ,300);	// put it in cache
		$end = microtime(true); // end time of query without cache
		//echo "oo:" . ($end - $start);
		//echo $page;
		$arr=$page;
$ss;
$str1 = explode ("[",$arr);
		if($str1[0]==null){

			$str = explode ("]",$arr);

			$ss = $str[0].',{'.'"without cache":' .'"'.($end - $start).'"}]';
			}else{
				$str = explode ("]",$arr);

				$ss = '['.$str[0].',{'.'" without cache":' .'"'.($end - $start).'"}]';
			}
		
	//echo $ss;
		
		//echo 
		return response()->json(json_decode($ss));
	}
}

	
	public function getBook($id){
		$start = microtime(true);	// start time of query
		if (Cache::has($id)){	// check if the item in cache
			$value = Cache::get($id);	// get it from cache
			$endcache = microtime(true); // end time of query with cache
			//echo "cache:" . ($endcache - $start);
			//echo $value;
			$arr = $value;
			$str = explode ("]",$arr);
			$ss = '['.$str[0].',{'.'"cache":' .'"'.($endcache - $start).'"}]';
			//echo $ss;
			return response()->json(json_decode($ss));
		}else{
		$url = '';
		$num = rand(1,4); // random load balancing algorithm
		if ($num < 3){
			$url = 'http://192.168.1.5:8000/query/bookid/' . $id;
		}
		else {
			$url = 'http://192.168.1.4:8000/query/bookid/' . $id;
		}
		$page = file_get_contents($url); // get book from catalogue
		Cache::put($id , $page ,300);	// put it in cache
		$end = microtime(true); // end time of query without cache
		///echo "oo:" . ($end - $start);
		$arr = $page;
		$str = explode ("]",$arr);
		$ss = '['.$str[0].',{'.'"without cache":' .'"'.($end - $start).'"}]';
//echo $ss;
		//return response()->json($obj);
		return response()->json(json_decode($ss));
	}
	}
	
	public function buyBook($id){
		$start = microtime(true);	// start time of query
		if (Cache::has('Buy' . $id)){	// check if the item in cache
			$value = Cache::get('Buy' . $id);	// get it from cache
			//$val = json_decode($value)->Message;
			//if ($val != 'Buy done successfuly.'){
				$endcache1 = microtime(true); // end time of query with cache
				//echo "cache:" . ($endcache1 - $start);
				$arr = $value;
		$str = explode ("]",$arr);
		$ss = '['.$str[0].',{'.'"cache":' .'"'.($endcache1 - $start).'"}]';

				return response()->json(json_decode($ss));
			//}
			Cache::forget('Buy' . $id);
		}else{
		$url = '';
		$num = rand(1,4);
		if ($num < 3){
			$url = 'http://192.168.1.6:8000/buy/' . $id;
		}
		else { 
			$url = 'http://192.168.1.8:8000/buy/' . $id;
		}

		$page = file_get_contents($url);
		Cache::put('Buy'.$id , $page ,60);	//// put it in cache
		$end = microtime(true); // end time of query without cache
		$arr = $page;
		$str = explode ("]",$arr);
		$ss = '['.$str[0].',{'.'"without cache":' .'"'.($end - $start).'"}]';

		return response()->json(json_decode($ss));
	}
}	
    //
}