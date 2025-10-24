<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\AuthController;
use Modules\Genres\GenreController;
use Modules\SystemRoles\SystemRoleController;
use Modules\Tags\TagController;
use Modules\TaskAttachments\TaskAttachmentController;
use Modules\TaskComments\TaskCommentController;
use Modules\TaskPriorities\TaskPriorityController;
use Modules\Tasks\TaskController;
use Modules\TaskStatuses\TaskStatusController;
use Modules\TaskTags\TaskTagController;
use Modules\TaskTypes\TaskTypeController;
use Modules\TeamRoles\TeamRoleController;
use Modules\Teams\TeamController;
use Modules\TeamUsers\TeamUserController;
use Modules\Users\UserController;

if (!function_exists('registerResourceRoutes')) {
    function registerResourceRoutes(string $prefix, string $controller, ?Closure $customRoutes = null)
    {
        Route::prefix($prefix)->group(function () use ($controller, $customRoutes) {
            Route::middleware('auth:api')->group(function () use ($controller) {
                Route::get('/', [$controller, 'findAll']);
                Route::post('/find-by-id', [$controller, 'findOneById']);
                Route::post('/', [$controller, 'create']);
                Route::patch('/', [$controller, 'partialUpdate']);
                Route::delete('/', [$controller, 'softDelete']);
                Route::post('/restore', [$controller, 'restoreDeleted']);
                Route::delete('/force', [$controller, 'hardDelete']);
            });

            // Aquí agrega se rutas personalizadas si se pasan
            if ($customRoutes) $customRoutes($controller);
        });
    }
}

Route::prefix('v1')->group(function () {
    // Rutas para Genres
    registerResourceRoutes('genres', GenreController::class);

    // Rutas para SystemRoles
    registerResourceRoutes('system-roles', SystemRoleController::class);

    // Rutas para Auth
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
        });
    });

    // Rutas para Users
    registerResourceRoutes('users', UserController::class);

    // Rutas para Teams
    registerResourceRoutes('teams', TeamController::class, function ($controller) {
        Route::middleware('auth:api')->group(function () use ($controller) {
            Route::post('/by-user', [$controller, 'getTeamsByUser']);
            Route::post('/with-roles/and-admin', [$controller, 'createTeamWithBasicTeamRolesAndTeamAdmin']);
        });
    });

    // Rutas para TeamRoles
    registerResourceRoutes('team-roles', TeamRoleController::class);

    // Rutas para TeamUsers
    registerResourceRoutes('team-users', TeamUserController::class);

    // Rutas para TaskTypes
    registerResourceRoutes('task-types', TaskTypeController::class);

    // Rutas para TaskPriorities
    registerResourceRoutes('task-priorities', TaskPriorityController::class);

    // Rutas para TaskStatuses
    registerResourceRoutes('task-statuses', TaskStatusController::class);

    // Rutas para Tasks
    registerResourceRoutes('tasks', TaskController::class, function ($controller) {
        Route::middleware('auth:api')->group(function () use ($controller) {
            Route::post('/by-team', [$controller, 'getTasksByTeam']);
        });
    });

    // Rutas para TaskCommentController
    registerResourceRoutes('task-comments', TaskCommentController::class);

    // Rutas para TaskAttachmentController
    registerResourceRoutes('task-attachments', TaskAttachmentController::class);

    // Rutas para TagController
    registerResourceRoutes('tags', TagController::class, function ($controller) {
        Route::middleware('auth:api')->group(function () use ($controller) {
            Route::post('/by-team', [$controller, 'getTagsByTeam']);
        });
    });

    // Rutas para TaskTagController
    registerResourceRoutes('task-tags', TaskTagController::class);
});
