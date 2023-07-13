<?php

namespace Database\Seeders;

use App\Models\Assignee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssigneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taskIds = Task::all()->pluck('id');
        $userIds = User::all()->pluck('id');

        foreach ($taskIds as $taskId) {

            foreach ($userIds as $userId) {

                Assignee::factory()->create([
                    "task_id" => $taskId,
                    "user_id" => $userId,
                ]);
            }
        }
    }
}
