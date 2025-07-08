<?php

namespace ErixCode\ManageGitModulesNwidart\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use File;

class GitBranchInModules extends Command
{
    protected $signature = 'module:git-branch-modules';
    protected $description = 'Runs git branch in all subdirectories of the Modules directory';

    public function handle()
    {
        $basepath = base_path();
        $this->info('Running git branch in ' . $basepath);
        $this->runGitBranchCommand($basepath);


        $modulesPath = base_path('Modules');
        if (!File::isDirectory($modulesPath)) {
            $this->error('Modules directory does not exist.');
            return 1;
        }
        // Get all subdirectories in the Modules directory
        $subdirectories = File::directories($modulesPath);
        // rungitbranchCOmmand for base path

        foreach ($subdirectories as $subdirectory) {
            $this->info('Running git branch in ' . $subdirectory);
            $this->runGitBranchCommand($subdirectory);
        }
        return 0;
    }
    private function runGitBranchCommand($subdirectory)
    {
        // Run 'git branch' command in each subdirectory
        $process = new Process(['git', 'branch'], $subdirectory);
        $process->run();

        // Output the result
        if ($process->isSuccessful()) {
            $this->info($process->getOutput());
        } else {
            $this->error($process->getErrorOutput());
        }
    }

}