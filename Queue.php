<?php 

// This file hold the redis connection and functions.

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

function RedisConfig(){
$redis = new Redis();  
$redis->connect('127.0.0.1', 6379);
$redisTimout= 30;//Seconds to wait for queue
$redisFractuality=10;// How many times per second to check the queue. This will effect your server performance 

return ["redis"=>$redis,"redisTimout"=>$redisTimout,"redisFractuality"=>$redisFractuality];
}


//This function adding thread to the queue and awaiting until its your turn.
//You can use your own keys if they are unique or leave it empty for random key
function QueueProcess($Qname,$key=""){
//Connecting to Redis server and get config 

$con = RedisConfig();

    if($key=="")$key=rand(0,876876868687);
	
	
	//Add the thread to the list
	$con['redis']->rpush($Qname, $key);
	
	  

	  
//Start awaiting for the queue. 
for ($k = 1 ; $k <= $con['redisTimout']*$con['redisFractuality']; $k++){ 

    //Awaiting until this thread will be first in the list
    if ($con['redis']->lindex($Qname,0)==$key){ 
       
       
        //return true - > you can process
        return true;
    }
    //Time to wait between loop requests
   usleep(1000000/$con['redisFractuality']);

 }   
    // If after the timout no true response we return false
    return false;

}
	    
	    //This function mark you done and let next process to start/
	  function QueueDone($Qname){
        $con = RedisConfig();
	    $con['redis']->lpop($Qname);
	    return true;
}


//When all done this function deleting the list from memory
	  function QueueDel($Qname){
        $con = RedisConfig();
	    $con['redis']->del($Qname);
	    return true;
}

//Delete all queues
	  function QueueDelAll(){
        $con = RedisConfig();
	    $con['redis']->flushall();
	    return true;
}

