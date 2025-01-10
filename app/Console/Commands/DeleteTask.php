<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:delete {id : The ID of the task to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a task by its primary key';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $id = $this->argument('id');

        $deleted = DB::table('tasks')->where('id', $id)->delete();

        if ($deleted) {
            $this->info("Task with ID {$id} deleted successfully.");
        } else {
            $this->error("No task found with ID {$id}.");
        }
    }
}
