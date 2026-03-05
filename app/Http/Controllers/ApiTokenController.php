<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tokens = $user->tokens()->get();

        return view('api-tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('api-tokens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $token = auth()->user()->createToken($validated['name']);

        return view('api-tokens.show', [
            'token' => $token->plainTextToken,
            'name' => $validated['name'],
        ]);
    }

    public function destroy($tokenId)
    {
        $token = auth()->user()->tokens()->findOrFail($tokenId);
        $token->delete();

        return redirect()->route('api-tokens.index')
            ->with('success', 'Token eliminado exitosamente');
    }
}
