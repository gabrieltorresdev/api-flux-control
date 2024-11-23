<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class GenerateModuleFiles extends Command
{
    protected $signature = 'generate:module-files {module?} {action?}';
    protected $description = 'Generates default files for a module based on stubs';

    private array $files = [];
    private array $createdFiles = [];
    private array $existingFiles = [];

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $module = $this->resolveParameter('module', 'What is the module name?');
        $action = $this->resolveOptionalParameter('action', 'What is the action name? (Leave blank for none)');

        $this->initializeFilePaths($module, $action);

        $filesToGenerate = $this->getNonExistingFiles($this->files);

        if (empty($filesToGenerate)) {
            $this->info("All files for module '$module' have already been created.");
            return;
        }

        $selectedFiles = $this->promptFileSelection($filesToGenerate);

        $this->generateFiles($selectedFiles, $module, $action);

        $this->displayGenerationSummary();
    }

    private function resolveParameter(string $name, string $prompt): string
    {
        return $this->argument($name) ?? text($prompt, 'E.g. User');
    }

    private function resolveOptionalParameter(string $name, string $prompt): ?string
    {
        return $this->argument($name) ?? text($prompt, 'E.g. Create');
    }

    private function initializeFilePaths(string $module, ?string $action): void
    {
        $baseFiles = [
            "app/Core/Domain/Repository/I{$module}Repository.php",
            "app/Core/Domain/Entity/{$module}.php",
            "app/Mapper/{$module}Mapper.php",
            "app/Persistence/Eloquent/Model/{$module}Model.php",
            "app/Persistence/Eloquent/Repository/{$module}Repository.php",
            "app/Http/Controllers/{$module}Controller.php",
        ];

        $actionFiles = $action ? [
            "app/Core/Application/{$module}/Action/{$action}{$module}Action.php",
            "app/Core/Application/{$module}/DTO/In{$action}{$module}.php",
            "app/Core/Application/{$module}/DTO/Out{$action}{$module}.php",
            "app/Http/Requests/{$action}{$module}Request.php",
        ] : [];

        $this->files = array_merge($baseFiles, $actionFiles);
    }

    private function getNonExistingFiles(array $files): array
    {
        return array_filter($files, fn($file) => !File::exists($file));
    }

    private function promptFileSelection(array $files): array
    {
        return multiselect('Select the files you want to generate:', $files);
    }

    /**
     * @throws Exception
     */
    private function generateFiles(array $selectedFiles, string $module, ?string $action): void
    {
        foreach ($selectedFiles as $filePath) {
            $this->createFile($filePath, $module, $action);
        }
    }

    /**
     * @throws Exception
     */
    private function createFile(string $filePath, string $module, ?string $action): void
    {
        if (File::exists($filePath)) {
            $this->existingFiles[] = $filePath;
            return;
        }

        $stubPath = $this->determineStubPath($filePath, $action);
        if (!File::exists($stubPath)) {
            $this->error("Stub not found: $stubPath");
            return;
        }

        $content = $this->populateStubContent($stubPath, $module, $action);
        $this->writeFile($filePath, $content);

        $this->createdFiles[] = $filePath;
    }

    /**
     * @throws Exception
     */
    private function determineStubPath(string $filePath, ?string $action): string
    {
        return base_path('stubs/' . match (true) {
                str_contains($filePath, '/Action/') => 'module-action.stub',
                str_contains($filePath, '/DTO/In') => 'module-dto-in.stub',
                str_contains($filePath, '/DTO/Out') => 'module-dto-out.stub',
                str_contains($filePath, '/Domain/Repository/') => 'module-repository-interface.stub',
                str_contains($filePath, '/Entity/') => 'module-entity.stub',
                str_contains($filePath, '/Eloquent/Repository/') => 'module-repository.stub',
                str_contains($filePath, '/Eloquent/Model/') => 'module-model.stub',
                str_contains($filePath, '/Mapper/') => 'module-mapper.stub',
                str_contains($filePath, '/Controllers/') => $this->selectControllerStub($action),
                str_contains($filePath, '/Requests/') => 'module-request.stub',
                default => throw new Exception("Stub not found for file: $filePath"),
            });
    }

    private function selectControllerStub(?string $action): string
    {
        return $action ? 'module-controller-with-action.stub' : 'module-controller.stub';
    }

    private function populateStubContent(string $stubPath, string $module, ?string $action): string
    {
        $content = File::get($stubPath);

        return str_replace(
            ['{{module}}', '{{Module}}', '{{action}}', '{{Action}}'],
            [strtolower($module), ucfirst($module), strtolower($action ?? ''), ucfirst($action ?? '')],
            $content
        );
    }

    private function writeFile(string $filePath, string $content): void
    {
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, $content);
    }

    private function displayGenerationSummary(): void
    {
        $this->info("\nSummary:");

        if (!empty($this->createdFiles)) {
            $this->info("\nCreated files:");
            $this->line(implode("\n - ", $this->createdFiles));
        }

        if (!empty($this->existingFiles)) {
            $this->info("\nExisting files:");
            $this->line(implode("\n - ", $this->existingFiles));
        }
    }
}
