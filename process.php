<?php
include("Queue.php");

//This code you includ in any of your files. you need to add one line when you start the process and one line when you finish your process.

$queue_name = "test_it";

//Start awaiting for queue. you need to give name for your queue
if (!QueueProcess($queue_name)==true)die("Queue timeout.");

//Here your can process safetly 

QueueDone($queue_name);

#Optional option to delete all the queue
//QueueDel($queue_name);
#Optional option to delete all the queues
//QueueDelAll();
