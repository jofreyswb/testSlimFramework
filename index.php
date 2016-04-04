<?php
 
require 'Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name! Welcome to Slim Framework";
});
 
$app->get(
    '/',
    function () {       
        echo require 'tpl/index.html';
    }
);
$app->post(
    '/test',
    function () use ($app){
 	$request = $app->request();
    $body = $request->getBody();
  
    $incDate = $app->request->post();

    $curentDate = strtotime(date('Y-m-d H:i:s')); 		//текущая дата
    $incomingDate = strtotime($incDate['incomdate']); 	// дата из запроса

    if($curentDate>$incomingDate) {   					//если текущая дата больше даты запроса 	
    	 $app->notFound();
    }else{
		$toIncomingDate = $incomingDate - $curentDate; 	// разница между датами
		
		$returnDate = array( 							//масив со сзначенниями до окончания пришедшей даты
		    "day" => $toIncomingDate / 86400,
		    "hours" => $toIncomingDate / 3600,
		    "minute" => $toIncomingDate / 60,
		    "second" => $toIncomingDate 
		); 

		$response = $app->response();
	    $response['Content-Type'] = 'application/json';	//Решил вернуть значенние в формате JSON
	    $response->status(200);
	    $response->body(json_encode($returnDate));    	
    }

}
);

$app->run();
 
?>