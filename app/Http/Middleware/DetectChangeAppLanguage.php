<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class DetectChangeAppLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $available_languages = ["id", "en"];

        if ($request->filled("lang")) {
          $lang = $request->input("lang");

          if (in_array($lang, $available_languages)) {
            $request->session()->put("lang", $lang);
            App::setLocale($lang);
          }
          if (in_array($lang, $available_languages)) {
            $request->session()->put("lang", $lang);
            App::setLocale($lang);
          }
        }
        
        if ($request->session()->has("lang")) {
          $lang = $request->session()->get("lang", "en");

          if (in_array($lang, $available_languages)) {
            $request->session()->put("lang", $lang);
            App::setLocale($lang);
          }
          if (in_array($lang, $available_languages)) {
            $request->session()->put("lang", $lang);
            App::setLocale($lang);
          }
        }
        
        return $next($request);
    }
}
