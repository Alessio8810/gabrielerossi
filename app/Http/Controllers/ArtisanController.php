<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    // Token segreto per maggiore sicurezza
    private $secretToken = 'rossi-auto-artisan-2025';

    public function index(Request $request)
    {
        // Verifica che l'utente sia autenticato
        if (!Auth::check()) {
            abort(403, 'Devi effettuare il login');
        }

        // Verifica token aggiuntivo per sicurezza
        if ($request->get('token') !== $this->secretToken) {
            abort(403, 'Token non valido');
        }

        $output = '';
        $command = $request->get('command');

        if ($command) {
            // Lista comandi permessi per sicurezza
            $allowedCommands = [
                'config:clear',
                'cache:clear',
                'route:clear',
                'view:clear',
                'optimize',
                'optimize:clear',
                'storage:link',
                'migrate',
                'db:seed',
            ];

            // Comandi speciali che non sono Artisan
            $shellCommands = [
                'npm-build' => 'cd ' . base_path() . ' && npm run build',
                'normalize-images' => 'cd ' . base_path() . ' && php scripts/normalize_images.php',
            ];

            if (in_array($command, $allowedCommands)) {
                Artisan::call($command);
                $output = Artisan::output();
            } elseif (isset($shellCommands[$command])) {
                // Esegui comando shell
                $output = shell_exec($shellCommands[$command] . ' 2>&1');
            } else {
                $output = "Comando non permesso. Comandi disponibili:\n" . implode("\n", array_merge($allowedCommands, array_keys($shellCommands)));
            }
        }

        return view('artisan.index', [
            'output' => $output,
            'command' => $command,
            'token' => $this->secretToken,
        ]);
    }

    public function clearAll(Request $request)
    {
        // Verifica che l'utente sia autenticato
        if (!Auth::check()) {
            abort(403, 'Devi effettuare il login');
        }

        // Verifica token
        if ($request->get('token') !== $this->secretToken) {
            abort(403, 'Token non valido');
        }

        $output = "Esecuzione comandi di pulizia...\n\n";

        $commands = [
            'config:clear',
            'cache:clear',
            'route:clear',
            'view:clear',
            'optimize',
        ];

        foreach ($commands as $cmd) {
            Artisan::call($cmd);
            $output .= "✓ {$cmd}\n";
            $output .= Artisan::output() . "\n";
        }

        $output .= "\n✓ Tutte le cache sono state pulite!";

        return view('artisan.index', [
            'output' => $output,
            'command' => 'clear-all',
            'token' => $this->secretToken,
        ]);
    }
}
