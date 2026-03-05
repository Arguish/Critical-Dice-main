#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
if ($user) {
    $token = $user->createToken('API Test Token');
    echo "User: " . $user->email . "\n";
    echo "User ID: " . $user->id . "\n";
    echo "Token: " . $token->plainTextToken . "\n";
} else {
    echo "No users found\n";
}
