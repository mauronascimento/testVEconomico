<?php
   
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Spatie\ArrayToXml\ArrayToXml;

require_once('../vendor/autoload.php');
require_once('../conf/conf.php');

$middlewareDir = opendir(MIDDLEWARE_PATH); 
while ($middleware = readdir($middlewareDir)) {
	if($middleware != '.' && $middleware != '..')
		require_once(MIDDLEWARE_PATH . $middleware);
}

$app = new \Slim\App;

//middleware session
$app->add(function ($request, $response, $next) {
    try{
        $ini_array = parse_ini_file('../conf/conf.ini', true);
        $HandlingSession = new HandlingSession($request, $ini_array);
        if(!$HandlingSession->validate()){
            $data = array('msg' => 'Unauthorized','http_code' => 401); 
            return $response->withJson($data, 401)->withHeader('Content-type', 'application/json');
        }

    }catch(Exception $e){
        $data = array('msg' => 'Error occured in validation','http_code' => 401); 
        return $response->withJson($data, 401)->withHeader('Content-type', 'application/json');
    }
        return $next($request, $response);
});

//middleware memcached
// $app->add(function ($request, $response, $next) {
// 	return $next($request, $response); // fazer depois
// });

//tratativa 404
unset($app->getContainer()['notFoundHandler']);
$app->getContainer()['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $data = array('msg' => 'Page not found','http_code' => 404); 
        $response = new \Slim\Http\Response(404);
        $return = $response->withJson($data, 404)->withHeader('Content-type', 'application/json');
        return $return;
    };
};

//tratativa 500 
unset($app->getContainer()['phpErrorHandler']);
$app->getContainer()['phpErrorHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $data = array('msg' => 'Application error','http_code' => 500); 
        $response = new \Slim\Http\Response(500);
        $return = $response->withJson($data, 500)->withHeader('Content-type', 'application/json');
        return $return;
    };
};

//rotas
$app->get('/', function (Request $request, Response $response, array $args) {
    echo 'aqui ficara o swagger';

});
$app->map(['POST', 'PUT', 'DELETE'], '/', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/allnews[/]', function (Request $request, Response $response, array $args) {
    $header = $request->getserverParams();

    require_once(CONTROLLERS_PATH.'AllnewsController.php');

    $AllnewsController = new AllnewsController();
    $data = $AllnewsController->getAllNews();

    if(isset($header['HTTP_RETURNTYPE']) && $header['HTTP_RETURNTYPE'] == 'application/xml'){
        $response->withHeader('Content-type', 'application/xml')->withStatus(200);
        $xml = ArrayToXml::convert($data, 'namespace',true,'UTF-8');
        return $response->write($xml);
    }

    $return = $response->withJson($data, 200)->withHeader('Content-type', 'application/json');
    return $return;

});
$app->map(['POST', 'PUT', 'DELETE'], '/allnews', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/newkeyword[/{keyword}]', function (Request $request, Response $response, array $args) {
    $header = $request->getserverParams();

    require_once(CONTROLLERS_PATH.'NewskeywordController.php');
    require_once('../helpers/Validatekeyword.php');

    $validate = Validatekeyword::validate($args);
    if(!$validate){
        $data = array('msg' => 'Not Acceptable','http_code' => 406); 
        $return = $response->withJson($data, 406)->withHeader('Content-type', 'application/json');
        return $return;
    }
    $NewskeywordController = new NewskeywordController();
    $data = $NewskeywordController->getNewsForkeyword($validate);

    if(isset($header['HTTP_RETURNTYPE']) && $header['HTTP_RETURNTYPE'] == 'application/xml'){
        $response->withHeader('Content-type', 'application/xml')->withStatus(200);
        $xml = ArrayToXml::convert($data, 'namespace',true,'UTF-8');
        return $response->write($xml);
    }

    $return = $response->withJson($data, 200)->withHeader('Content-type', 'application/json');
    return $return;
});
$app->map(['POST', 'PUT', 'DELETE'], '/newkeyword', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/fordate[/{initialDate}[/{endDate}]]', function (Request $request, Response $response, array $args) {
    //0000-00-00
    $header = $request->getserverParams();

    require_once(CONTROLLERS_PATH.'FordateController.php');
    require_once('../helpers/Validatekeyword.php');

    $validate = Validatekeyword::validateDate($args);
    
    if(!$validate){
        $data = array('msg' => 'Not Acceptable','http_code' => 406); 
        $return = $response->withJson($data, 406)->withHeader('Content-type', 'application/json');
        return $return;
    }

    $FordateController = new FordateController();
    $data = $FordateController->getNewsForDate($args);

    if(isset($header['HTTP_RETURNTYPE']) && $header['HTTP_RETURNTYPE'] == 'application/xml'){
        $response->withHeader('Content-type', 'application/xml')->withStatus(200);
        $xml = ArrayToXml::convert($data, 'namespace',true,'UTF-8');
        return $response->write($xml);
    }

    $return = $response->withJson($data, 200)->withHeader('Content-type', 'application/json');
    return $return;

});
$app->map(['POST', 'PUT', 'DELETE'], '/fordate', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/amounthour[/]', function (Request $request, Response $response, array $args) {
    $header = $request->getserverParams();

    require_once(CONTROLLERS_PATH.'AmounthourController.php');

    $AmounthourController = new AmounthourController();
    $data = $AmounthourController->getCountLatsHour();

    if(isset($header['HTTP_RETURNTYPE']) && $header['HTTP_RETURNTYPE'] == 'application/xml'){
        $response->withHeader('Content-type', 'application/xml')->withStatus(200);
        $xml = ArrayToXml::convert($data, 'namespace',true,'UTF-8');
        return $response->write($xml);
    }

    $return = $response->withJson($data, 200)->withHeader('Content-type', 'application/json');
    return $return;

});
$app->map(['POST', 'PUT', 'DELETE'], '/amounthour', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->run();