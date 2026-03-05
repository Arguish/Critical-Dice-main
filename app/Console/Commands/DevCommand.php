<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev {--host=127.0.0.1} {--port=8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start development environment (Laravel server + Vite hot reload)';

    private $processes = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');

        $this->info('🚀 Starting development environment...');
        $this->line('');
        $this->comment('  📦 Vite (Hot Reload)');
        $this->comment("  🌐 Laravel Server: http://{$host}:{$port}");
        $this->line('');
        $this->warn('  Press Ctrl+C to stop all servers');
        $this->line('');
        $this->line(str_repeat('─', 60));
        $this->line('');

        // Registrar manejador de señales para limpieza
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGINT, [$this, 'cleanup']);
            pcntl_signal(SIGTERM, [$this, 'cleanup']);
        }

        // Iniciar Vite en segundo plano
        $this->startVite();

        // Iniciar servidor Laravel (bloquea hasta Ctrl+C)
        $this->startLaravelServer($host, $port);

        return 0;
    }

    /**
     * Start Vite development server
     */
    private function startVite(): void
    {
        $isWindows = DIRECTORY_SEPARATOR === '\\';

        if ($isWindows) {
            // En Windows, usar start para abrir en nueva ventana
            $command = 'start "Vite Dev Server" cmd /k "npm run dev"';
            pclose(popen($command, 'r'));
        } else {
            // En Unix/Linux/Mac
            $descriptors = [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];

            $process = proc_open(
                'npm run dev',
                $descriptors,
                $pipes,
                getcwd(),
                null,
                ['bypass_shell' => false]
            );

            if (is_resource($process)) {
                $this->processes['vite'] = $process;
                
                // Leer salida en un hilo separado (simulado)
                stream_set_blocking($pipes[1], false);
                stream_set_blocking($pipes[2], false);
            }
        }

        // Dar tiempo para que Vite arranque
        sleep(2);
    }

    /**
     * Start Laravel development server
     */
    private function startLaravelServer(string $host, string $port): void
    {
        $command = sprintf('php -S %s:%s -t public', $host, $port);
        
        $this->info('✅ Servers started successfully!');
        $this->line('');
        
        // Este comando bloquea hasta Ctrl+C
        passthru($command);
    }

    /**
     * Cleanup processes on exit
     */
    public function cleanup(): void
    {
        $this->line('');
        $this->comment('🛑 Stopping servers...');

        foreach ($this->processes as $name => $process) {
            if (is_resource($process)) {
                proc_terminate($process);
                proc_close($process);
            }
        }

        $this->info('✅ All servers stopped');
        exit(0);
    }

    /**
     * Handle destructor
     */
    public function __destruct()
    {
        foreach ($this->processes as $process) {
            if (is_resource($process)) {
                proc_close($process);
            }
        }
    }
}

