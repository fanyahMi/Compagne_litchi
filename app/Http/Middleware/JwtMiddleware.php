<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Firebase\JWT\Key;;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token manquant'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(Config::get('jwt.secret'), 'HS256'));
            $request->attributes->add(['user' => $decoded]);

        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token expiré'], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => 'Signature du token invalide'], 401);
        } catch (BeforeValidException $e) {
            return response()->json(['error' => 'Le token n\'est pas encore valide'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token invalide: ' . $e->getMessage()], 401);
        }

        return $next($request);
    }
}
