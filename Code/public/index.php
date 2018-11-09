<?php
   
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


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

// //middleware memcached
$app->add(function ($request, $response, $next) {
	return $next($request, $response); // fazer depois
});

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

$app->get('/allnews', function (Request $request, Response $response, array $args) {
    echo 'aqui ficara todas noticias';

});

$app->map(['POST', 'PUT', 'DELETE'], '/allnews', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/newkeyword', function (Request $request, Response $response, array $args) {
    echo 'aqui ficara todas noticias newkeyword';

});
$app->map(['POST', 'PUT', 'DELETE'], '/newkeyword', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/fordate', function (Request $request, Response $response, array $args) {
    echo 'aqui ficara todas noticias fordate';

});
$app->map(['POST', 'PUT', 'DELETE'], '/fordate', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->get('/amounthour', function (Request $request, Response $response, array $args) {
    echo 'aqui ficara todas noticias';

});
$app->map(['POST', 'PUT', 'DELETE'], '/amounthour', function ($request, $response, $args) {
    $data = array('msg' => 'Method Not Allowed','http_code' => 405); 
    $return = $response->withJson($data, 405)->withHeader('Content-type', 'application/json');
    return $return;
});

$app->run();