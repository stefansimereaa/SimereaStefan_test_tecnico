<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            'Prepare Monthly Report',
            'Team Meeting: Project Updates',
            'Finalize Budget Proposal',
            'Research Competitor Strategies',
            'Update Website Content',
            'Organize Office Files',
            'Review Marketing Campaign',
            'Plan Quarterly Goals',
            'Draft Client Email Templates',
            'Schedule Social Media Posts',
        ];

        $tasks = [];

        foreach ($titles as $title) {
            $tasks[] = [
                'title' => $title,
                'description' => 'This is the description for ' . $title,
                'is_closed' => rand(0, 1),
                'due_date' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }


         DB::table('tasks')->insert($tasks);
    }
}
