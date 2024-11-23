<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\suggest;

class GenerateModuleFilesCommand extends Command
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
        return ucwords(
            str($this->argument($name) ?? suggest($prompt, $this->getModules(), 'E.g. User'))->camel()
        );
    }

    protected function getModules(): array
    {
        $entitiesPath = base_path('app/Core/Domain/Entity');
        $modulesPath = base_path('app/Core/Application');

        $entityFiles = File::exists($entitiesPath)
            ? File::files($entitiesPath)
            : [];

        $moduleDirectories = File::exists($modulesPath)
            ? File::directories($modulesPath)
            : [];

        $entities = array_map(
            fn($file) => $file->getFilenameWithoutExtension(),
            $entityFiles
        );

        $entities = array_values(array_filter($entities, fn($entity) => $entity !== "Entity"));

        $modules = array_map(
            fn($path) => basename($path),
            $moduleDirectories
        );

        return array_unique(array_merge($entities, $modules));
    }

    private function resolveOptionalParameter(string $name, string $prompt): ?string
    {
        return ucwords(
            str($this->argument($name) ?? suggest($prompt, [
                "Create",
                "List",
                "Show",
                "Update",
                "Delete"
            ], 'E.g. Create'))->camel()
        );
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
            "database/factories/{$module}Factory.php",
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
        return array_values(array_filter($files, fn($file) => !File::exists($file)));
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

        $hasAction = !empty($action);
        $hasRequest = str_contains(implode('', $this->files), '/Http/Requests/');

        $stubPath = $this->getStubPath($filePath, $hasAction, $hasRequest);
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
    private function getStubPath(string $filePath, bool $hasAction, bool $hasRequest): string
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
                str_contains($filePath, '/Controllers/') => $this->getControllerStub($hasAction, $hasRequest),
                str_contains($filePath, '/Requests/') => 'module-request.stub',
                str_contains($filePath, 'database/factories/') => 'module-factory.stub',
                default => throw new Exception("Stub not found for file: $filePath"),
            });
    }

    private function getControllerStub(bool $hasAction, bool $hasRequest): string
    {
        if ($hasAction && $hasRequest) {
            return 'module-controller-with-action-and-request.stub';
        }

        if ($hasAction) {
            return 'module-controller-with-action.stub';
        }

        if ($hasRequest) {
            return 'module-controller-with-request.stub';
        }

        return 'module-controller.stub';
    }

    private function populateStubContent(string $stubPath, string $module, ?string $action): string
    {
        $content = File::get($stubPath);

        return str_replace(
            ['{{module}}', '{{Module}}', '{{action}}', '{{Action}}'],
            [str($module)->camel(), ucfirst(str($module)->camel()), str($action ?? '')->camel(), ucfirst(str($action ?? '')->camel())],
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

        if (empty($this->createdFiles)) {
            $this->info("\nNo file created.");
        }
    }
}
