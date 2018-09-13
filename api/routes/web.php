<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/apod', function () {
    $date = \Carbon\Carbon::now();

    $cachedFile = storage_path('app/' . $date->format('Y-m-d')) . '.json';

    if (file_exists($cachedFile)) {
        $data = json_decode(file_get_contents($cachedFile), JSON_OBJECT_AS_ARRAY);
        if ($data['media_type'] == 'image') {
            $data['url'] = url('cache/' . basename($data['url']));
        }

        return response()->json($data);
    } 

    $client = new GuzzleHttp\Client();
    $result = $client->request('GET', 'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY');
    $data = json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);
    if ($data['media_type'] == 'image') {
        $filename = basename($data['url']);
        $fileToSave = base_path('public/cache/' . $filename);
        $resource = fopen($fileToSave, 'w+');
        $client->request('GET', $data['url'], ['sink' => $resource]);
        $data['url'] = url('cache/' . $filename);
    }
    
    file_put_contents($cachedFile, json_encode($data));
    
    return response()->json($data);
});
