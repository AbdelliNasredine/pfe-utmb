<?php

namespace App\Middleware;

class LanguageMiddleware {

    protected $container;

    public function __construct($available_languages, $default_language, $container) {

        if(!is_array($available_languages)) {
            $available_languages = array($available_languages);
        }

        $this->container = $container;
        $this->container['default_language'] = $default_language;
        $this->container['available_languages'] = $available_languages;
        $this->container['language'] = $default_language;
    }

    public function __invoke($request, $response, $next) {

        $uri = $request->getUri();
        $path = $uri->getPath();
        
        $pathChunks = explode("/", $path); 

        if ( count($pathChunks) > 1 && in_array($pathChunks[1], $this->container['available_languages']) ) {
            
            $this->container['language'] = $pathChunks[1];   
            unset($pathChunks[1]); 
            $newPath = implode('/', $pathChunks);
            $newUri = $uri->withPath($newPath);

            return $next($request->withUri($newUri), $response); 
        }
        return $next($request, $response);
    }
}
