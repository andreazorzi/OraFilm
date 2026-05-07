<?php

namespace App\Http\Controllers;

use App\Classes\Help;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use LaravelLang\Locales\Facades\Locales;
use Symfony\Component\HttpFoundation\Response;

class RouteController extends Controller
{
    public static function languages($sort = false){
        $languages = Locales::installed()->pluck("code")->toArray();
        
        if($sort){
            $default = config('app.fallback_locale');
            $ordered_languages = [];
            
            if(in_array($default, $languages)){
                $ordered_languages[] = $default;
                array_splice($languages, array_search($default, $languages), 1);
            }
            
            $languages = array_merge($ordered_languages, $languages);
        }
        
        return $languages;
    }
    
    public static function translated_routes(){
        foreach (self::languages() ?? [] as $language) {
            $lang_prefix = config('app.locale') != $language ? "{$language}/" : '';
            
            foreach(Help::translate("tolgee/pages", default: []) as $page => $data){
                if(!empty($data['do_not_route'])) continue;
                
                $translations = array_merge(
                    ["_page" => $page],
                    Help::translate("tolgee/pages.{$page}", default: [], locale: $language)
                );
                
                try {
                    $slug = $page == "index" ? "" : ($translations["slug"] ?? Str::slug($translations["meta_title"] ?? $page));
                    Route::view($lang_prefix.$slug, $translations["view"] ?? $page, ['page' => $translations], headers: ["page" => $page])->name("{$page}.{$language}");
                } catch (\Throwable $th) {
                    throw new Exception("Make sure [$page - $language] translations are set", 1);
                }
            }
        }
    }
    
    public static function menu_routes(){
        $routes = [];
    
        foreach(Route::getRoutes() as $route){
            if(Str::contains($route->getName(), "backoffice.") && ($route->defaults["headers"]["menu"] ?? false) && User::current()->canAccessRoute($route)){
                $page_name = Str::replace("backoffice.", "", $route->getName());
                $page = config("routes.pages.$page_name");
                $routes[] = [
                    "title" => $page["title"],
                    "route" => $route->getName(),
                    "color" => $page["color"],
                    "icon" => $page["icon"],
                    "group" => $route->defaults["headers"]["menu-group"] ?? null,
                    "weight" => $route->defaults["headers"]["weight"] ?? 0,
                ];
            }
        }
        
        $groups = array_column($routes, 'group');
        $weights = array_column($routes, 'weight');
        $keys = array_keys($routes);

        array_multisort(
            $groups, SORT_DESC,
            $weights, SORT_ASC,
            $keys, SORT_ASC,
            $routes
        );
        
        return $routes;
    }
    
    public static function passesMiddleware($user, $middleware){
        try {
            $router = app(Router::class);

            // Parse "role:admin,editor" → name: "role", params: ["admin", "editor"]
            [$name, $paramString] = array_pad(explode(':', $middleware, 2), 2, '');
            $params = $paramString !== '' ? explode(',', $paramString) : [];

            // Resolve middleware class (alias map → fallback to FQCN)
            $middlewareClass = $router->getMiddleware()[$name] ?? $name;

            // Fake request with this user as the authenticated user
            $request = Request::create('/');
            $request->setUserResolver(fn () => $user);

            // Execute the middleware
            $response = app($middlewareClass)->handle(
                $request,
                fn () => new Response('', 200),
                ...$params
            );

            return $response->isSuccessful();

        } catch (\Throwable $e) {
            return false;
        }
    }
    
    public function backoffice_index(){
        if(Auth::check()){
            if(!is_null(session("website.redirect"))){
                $redirect = session("website.redirect");
                session()->forget("website.redirect");
                return redirect($redirect);
            }
            
            return view('backoffice.index');
        }
        
        Auth::logout();
        
        return view('backoffice.login');
    }
    
    public static function texts(){
        $page = request()->route()->defaults["headers"]["page"];
        
        return is_null($page) ? [] : array_merge(
            ["_page" => $page],
            Help::translate("tolgee/pages.{$page}")
        );
    }
    
    public static function route($page, $language = null, $parameters = []){
        $language = $language ?? App::getLocale();
        
        return route("{$page}.{$language}", $parameters);
    }
}
