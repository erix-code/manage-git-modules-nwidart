<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use File;

class GitPullInModules extends Command
{
    protected $signature = 'module:git-pull-modules {branch=master}';
    protected $description = 'Runs git pull in all subdirectories of the Modules directory';

    public function handle()
    {
        $branch = $this->argument('branch');
        $basepath = base_path();
        $this->info('Running git pull in ' . $basepath);
        $this->runGitPullCommand($basepath, $branch);

        $modulesPath = base_path('Modules');
        if (!File::isDirectory($modulesPath)) {
            $this->error('Modules directory does not exist.');
            return 1;
        }

        // Get all subdirectories in the Modules directory
        $subdirectories = File::directories($modulesPath);

        foreach ($subdirectories as $subdirectory) {
            $this->info('Running git pull in ' . $subdirectory);
            $this->runGitPullCommand($subdirectory, $branch);
        }
        return 0;
    }

    private function runGitPullCommand($subdirectory, $branch)
    {
        // Run 'git pull' command in each subdirectory
        $process = new Process(['git', 'pull', 'origin', $branch], $subdirectory);
        $process->run();

        // Output the result
        if ($process->isSuccessful()) {
            $this->info($process->getOutput());
        } else {
            $this->error($process->getErrorOutput());
        }
    }
}