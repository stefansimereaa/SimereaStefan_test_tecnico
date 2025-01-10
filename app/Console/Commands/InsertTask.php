<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:insert 
                            {title : The title of the task} 
                            {description : The description of the task} 
                            {--due_date= : Optional due date (Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a new task with basic information';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $title = $this->argument('title');
        $description = $this->argument('description');
        $dueDate = $this->option('due_date');

        if ($dueDate && !strtotime($dueDate)) {
            $this->error('The due date format is invalid. Use Y-m-d.');
            return;
        }

        DB::table('tasks')->insert([
            'title' => $title,
            'description' => $description,
            'is_closed' => false,
            'due_date' => $dueDate ? Carbon::parse($dueDate)->toDateString() : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->info('Task inserted successfully!');
    }
}
