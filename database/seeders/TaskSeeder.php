<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            [
                'title' => 'Complete project proposal',
                'description' => 'Write and submit the project proposal for client review',
                'priority' => 'High',
                'status' => 'In Progress',
                'due_date' => Carbon::now()->addDays(3),
            ],
            [
                'title' => 'Update documentation',
                'description' => 'Update API documentation with new endpoints',
                'priority' => 'Medium',
                'status' => 'Pending',
                'due_date' => Carbon::now()->addDays(7),
            ],
            [
                'title' => 'Fix login bug',
                'description' => 'Resolve authentication issue in production',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Design database schema',
                'description' => 'Create ERD and schema for new feature',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Team meeting',
                'description' => 'Weekly sprint planning meeting',
                'priority' => 'Low',
                'status' => 'In Progress',
                'due_date' => Carbon::now()->addDays(1),
            ],
            [
                'title' => 'Code review',
                'description' => 'Review pull requests from team members',
                'priority' => 'Medium',
                'status' => 'Pending',
                'due_date' => Carbon::now()->addDays(2),
            ],
            [
                'title' => 'Deploy to staging',
                'description' => 'Deploy latest changes to staging environment',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::now()->addDays(4),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}