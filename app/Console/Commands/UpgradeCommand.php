<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpgradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install/update all project dependencies (Composer + NPM)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Upgrading project dependencies...');
        $this->line('');

        // 1. Composer install
        $this->comment('📦 Installing Composer dependencies...');
        $composerResult = $this->executeCommand('composer install');
        
        if ($composerResult !== 0) {
            $this->error('❌ Composer install failed!');
            return 1;
        }
        
        $this->info('✅ Composer dependencies installed successfully');
        $this->line('');

        // 2. NPM install
        $this->comment('📦 Installing NPM dependencies...');
        $npmResult = $this->executeCommand('npm install');
        
        if ($npmResult !== 0) {
            $this->error('❌ NPM install failed!');
            return 1;
        }
        
        $this->info('✅ NPM dependencies installed successfully');
        $this->line('');

        // Success
        $this->info('🎉 All dependencies upgraded successfully!');
        $this->line('');
        $this->comment('You can now run:');
        $this->line('  • php artisan dev    (Start development server)');
        $this->line('  • php artisan serve  (Start Laravel only)');
        
        return 0;
    }

    /**
     * Run a shell command and show output in real-time
     */
    private function executeCommand(string $command): int
    {
        $process = proc_open(
            $command,
            [
                0 => ['pipe', 'r'], // stdin
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w'], // stderr
            ],
            $pipes
        );

        if (!is_resource($process)) {
            return 1;
        }

        fclose($pipes[0]);

        // Read output in real-time
        while (!feof($pipes[1])) {
            $line = fgets($pipes[1]);
            if ($line !== false) {
                $this->line('  ' . trim($line));
            }
        }

        fclose($pipes[1]);
        fclose($pipes[2]);

        return proc_close($process);
    }
}

