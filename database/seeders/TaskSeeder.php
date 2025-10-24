<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Tasks\TaskModel;
use Modules\Teams\TeamModel;
use Modules\TaskTypes\TaskTypeModel;
use Modules\TaskPriorities\TaskPriorityModel;
use Modules\TaskStatuses\TaskStatusModel;
use Modules\Users\UserModel;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los IDs de usuarios, equipos, tipos, prioridades y estados
        $userIds = UserModel::pluck('id')->toArray();
        $teamIds = TeamModel::pluck('id')->toArray();
        $typeIds = TaskTypeModel::pluck('id')->toArray();
        $priorityIds = TaskPriorityModel::pluck('id')->toArray();
        $statusIds = TaskStatusModel::pluck('id')->toArray();

        // Lista de tareas de ejemplo
        $tasks = [
            [
                'title' => 'Preparar presentación de proyecto',
                'description' => 'Diapositivas + notas para el comité',
            ],
            [
                'title' => 'Implementar API de autenticación',
                'description' => 'Endpoints: login, logout, refresh token',
            ],
            [
                'title' => 'Revisar pruebas unitarias',
                'description' => 'Cobertura mínima 80%',
            ],
            [
                'title' => 'Diseñar wireframes de la app',
                'description' => 'Home, Login, Dashboard',
            ],
            [
                'title' => 'Configurar entorno de CI/CD',
                'description' => 'Pipelines para build y tests',
            ],
            [
                'title' => 'Documentar arquitectura',
                'description' => 'Diagrama de componentes y README',
            ],
        ];

        $now = Carbon::now();

        foreach ($tasks as $task) {
            // Asignar valores aleatorios para las relaciones y campos extra
            $task['team_id'] = Arr::random($teamIds);

            // Buscar usuarios que pertenezcan a ese equipo
            $teamUserIds = DB::table('team_users')
                ->where('team_id', $task['team_id'])
                ->pluck('user_id')
                ->toArray();

            // Si el equipo no tiene usuarios, saltar esta tarea
            if (empty($teamUserIds)) {
                continue;
            }

            // Asignar los demás valores aleatorios
            $task['task_type_id'] = Arr::random($typeIds);
            $task['task_priority_id'] = Arr::random($priorityIds);
            $task['task_status_id'] = Arr::random($statusIds);
            $task['created_by'] = Arr::random($teamUserIds);
            $task['assigned_to'] = Arr::random($teamUserIds);

            // // Generar fecha aleatoria entre 1 y 2 meses
            // $task['due_date'] = $now
            //     ->addDays(rand(30, 60)) // aleatorio entre 30 y 60 días
            //     ->setTime(rand(8, 18), rand(0, 59), 0) // hora aleatoria entre 8:00 y 18:59
            //     ->format('Y-m-d H:i:s');

            // Generar fecha de vencimiento aleatoria entre 1 y 2 meses o nula
            $task['due_date'] = rand(0, 1) ? $now->copy()
                ->addDays(rand(30, 60))
                ->setTime(rand(8, 18), rand(0, 59), 0)
                ->format('Y-m-d H:i:s') : null;

            TaskModel::create($task);
        }
    }
}
