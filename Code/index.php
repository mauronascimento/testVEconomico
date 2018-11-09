<?php
   
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Exception;

define('CONTROLLERS_PATH', 'controllers/');
define('MIDDLEWARE_PATH', 'middleware/');

require_once('vendor/autoload.php');

$middlewareDir = opendir(MIDDLEWARE_PATH); 
while ($middleware = readdir($middlewareDir)) {
	if($middleware != '.' && $middleware != '..')
		require_once(MIDDLEWARE_PATH . $middleware);
}

$app = new \Slim\App;

//middleware session
$app->add(function ($request, $response, $next) {
    try{
        $ini_array = parse_ini_file('conf/conf.ini', true);
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

// //middleware memcached
$app->add(function ($request, $response, $next) {
	print_r($request); die;
});

//rotas
$app->get('/', function (Request $request, Response $response, array $args) {
echo 'aqui ficara o swagger';

});

$app->post('/', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->put('/', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->delete('/', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/allnews', function (Request $request, Response $response, array $args) {
echo 'aqui ficara todas noticias';

});

$app->post('/allnews', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->put('/allnews', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->delete('/allnews', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/newkeyword/{keyword}', function (Request $request, Response $response, array $args) {
echo 'aqui ficara todas noticias por keyword';

});

$app->post('/newkeyword', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->put('/newkeyword', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->delete('/newkeyword', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/fordate/{date}', function (Request $request, Response $response, array $args) {
echo 'aqui ficara todas noticias por data';

});

$app->post('/fordate', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->put('/fordate', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->delete('/fordate', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/amounthour', function (Request $request, Response $response, array $args) {
echo 'aqui ficara todas noticias ultima hora';

});

$app->post('/amounthour', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->put('/amounthour', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->delete('/amounthour', function (Request $request, Response $response, array $args) {
	$data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->run();