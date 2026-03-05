<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateApiToken extends Command
{
    protected $signature = 'api:token {user_id} {name=API Token}';
    protected $description = 'Create an API token for a user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $tokenName = $this->argument('name');

        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return 1;
        }

        $token = $user->createToken($tokenName);

        $this->info("✅ API Token created successfully!");
        $this->line("");
        $this->info("User: {$user->name} ({$user->email})");
        $this->info("Token Name: {$tokenName}");
        $this->line("");
        $this->warn("⚠️  COPY THIS TOKEN NOW - It will not appear again:");
        $this->line("");
        $this->comment($token->plainTextToken);
        $this->line("");
        $this->info("Use it in Postman as:");
        $this->comment("Authorization: Bearer {$token->plainTextToken}");

        return 0;
    }
}
