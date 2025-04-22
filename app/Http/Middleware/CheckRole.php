<?php

// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next):Response
    {
       // Option 1: From authenticated user (recommended if using Sanctum or Passport)
    //    $user = auth()->user();

       // Option 2: OR if you're passing user ID directly (e.g., in API requests)
       $user = User::find($request->input('id'));

       if (!$user || $user->role !== 'admin') {
           return response()->json(['message' => 'Access denied. Admins only.'], 403);
       }

       return $next($request);
    }
}

