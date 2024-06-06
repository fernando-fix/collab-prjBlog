<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEnvironmentVariables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:update {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update environment variables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = $this->argument('value');

        // Ler o conteúdo do arquivo .env
        $envFilePath = base_path('.env');
        $envContent = file_get_contents($envFilePath);

        // Verificar se a variável de ambiente já existe no arquivo .env
        if (strpos($envContent, "$key=") !== false) {
            // Se existe, atualizar seu valor
            $envContent = preg_replace("/$key=.*/", "$key=$value", $envContent);
        } else {
            // Se não existe, adicionar ao final do arquivo
            $envContent .= "\n$key=$value";
        }

        // Escrever as mudanças de volta no arquivo .env
        file_put_contents($envFilePath, $envContent);

        $this->info("Variável de ambiente $key atualizada com sucesso.");
    }
}
