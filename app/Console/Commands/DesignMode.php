<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DesignMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design {--host=127.0.0.1} {--port=8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start development server in design mode (skip session validations for easy view testing)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');

        $this->info('🎨 Starting server in DESIGN MODE...');
        $this->line('');
        $this->comment('  ✅ Session validations: DISABLED');
        $this->comment('  ✅ Direct access to all views: ENABLED');
        $this->comment('  ✅ Perfect for designing and testing layouts');
        $this->line('');
        $this->warn('  ⚠️  Do NOT use this mode in production!');
        $this->line('');
        $this->info("  Server running on: http://{$host}:{$port}");
        $this->line('');
        $this->comment('  Press Ctrl+C to stop the server');
        $this->line('');

        // Establecer variable de entorno para este proceso
        putenv('DESIGN_MODE=true');
        $_ENV['DESIGN_MODE'] = true;
        $_SERVER['DESIGN_MODE'] = true;

        // Iniciar servidor con la variable de entorno
        $command = sprintf(
            'DESIGN_MODE=true php -S %s:%s -t public',
            $host,
            $port
        );

        // En Windows, el comando es diferente
        if (DIRECTORY_SEPARATOR === '\\') {
            $command = sprintf(
                'set DESIGN_MODE=true && php -S %s:%s -t public',
                $host,
                $port
            );
        }

        passthru($command);

        return 0;
    }
}
