<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class GenericController extends BaseController
{
    // Variable para definir el nombre de la entidad/tabla principal para mensajes del controlador
    // protected string $resourceName = 'registro';
    // Nombre del recurso usado para traducciones (ej: 'users', 'teams', 'tasks')
    // protected string $resourceName;

    // Variable para definir el controlador concreto
    protected string $model;

    // Reglas por acción (pueden usarse placeholders {id} para unique en update)
    protected array $createRules = [];
    protected array $updateRules = [];

    // Campos que se copiarán desde el request al modelo
    protected array $fillable = [];

    // Nombre de la PK (por defecto id)
    protected string $pkName = 'id';

    // Regla de validación para la PK (uuid|integer...)
    protected string $pkRule = 'required|integer';

    // Definir mensaje de éxito/error en base a la acción realizada
    // protected function makeMessage(string $action): string
    // {
    //     return ucfirst($this->resourceName) . " {$action} correctamente";
    // }

    /*** Hooks que pueden ser overrideados en la subclase ***/
    protected function beforeCreate(array $input): array
    {
        return $input;
    }

    protected function beforeUpdate(array $input, $record): array
    {
        return $input;
    }

    // Validador para el modelo
    protected function model(): string
    {
        if (!isset($this->model)) {
            throw new \RuntimeException('Property $model must be defined in the child controller.');
        }
        return $this->model;
    }

    // Obtiene los campos fillable definidos en el modelo
    protected function getFillable(): array
    {
        $modelClass = $this->model();

        if (!class_exists($modelClass)) {
            throw new \RuntimeException("The model {$modelClass} does not exist.");
        }

        $instance = new $modelClass();
        $fillable = $instance->getFillable();

        if (empty($fillable)) {
            throw new \RuntimeException("The model {$modelClass} has no defined 'fillable' fields.");
        }

        return $fillable;
    }

    /**
     * msg: obtiene el mensaje localizado.
     * - Busca el nombre del recurso en resources.{resource}.name/_plural
     * - Luego obtiene la plantilla en generic.{key} y reemplaza :resource y demás placeholders
     *
     * Uso: $this->msg('created'), $this->msg('not_found_any', [], true)
     */
    // protected function msg(string $key, array $replacements = [], bool $plural = false): string
    // {
    //     $resource = $this->resourceName ?? 'resource';
    //     // Intentar obtener etiqueta del recurso (singular o plural)
    //     $labelKey = "resources.{$resource}." . ($plural ? 'name_plural' : 'name');
    //     $resourceLabel = __($labelKey);

    //     // Si la clave no existe en resources, usamos el resourceName capitalizado como fallback
    //     if ($resourceLabel === $labelKey) {
    //         $resourceLabel = ucfirst(str_replace('_', ' ', $resource));
    //     }

    //     $replacements = array_merge(['resource' => $resourceLabel], $replacements);

    //     // Obtener mensaje genérico (ej: generic.created)
    //     $messageKey = "generic.{$key}";
    //     $message = __($messageKey, $replacements);

    //     // Si no existiera la clave generic, devolvemos un fallback simple
    //     if ($message === $messageKey) {
    //         // fallback mínimo
    //         return $replacements['resource'] . ' - ' . $key;
    //     }

    //     return $message;
    // }

    public function findAll()
    {
        try {
            $data = $this->model()::all();

            return $data->isNotEmpty()
                ? response()->json($data, 200)
                : $this->notFoundResponse('No se encontraron registros');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Obtener registros', $e);
        }
    }

    public function findOneById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->pkName => $this->pkRule,
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $record = $this->model()::find($request->input($this->pkName));

            return $record
                ? response()->json($record, 200)
                : $this->notFoundResponse('No se encontró el registro indicado');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Buscar por ID', $e);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->createRules);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $input = $request->only($this->getFillable());
            $input = $this->beforeCreate($input);

            $this->model()::create($input);

            return $this->successResponse('Registro creado correctamente');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Crear registro', $e);
        }
    }

    public function partialUpdate(Request $request)
    {
        $rules = array_merge([$this->pkName => $this->pkRule], $this->updateRules);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $record = $this->model()::find($request->input($this->pkName));

            if (!$record) return $this->notFoundResponse('No se encontró el registro indicado');

            $input = $request->only($this->getFillable());
            $input = $this->beforeUpdate($input, $record);

            $record->fill($input);
            $record->save();

            return $this->successResponse('Registro actualizado correctamente', 201);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Actualizar registro', $e);
        }
    }

    public function softDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [$this->pkName => $this->pkRule]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $record = $this->model()::find($request->input($this->pkName));

            if (!$record) return $this->notFoundResponse('No se encontró el registro indicado');

            $record->delete();

            return $this->successResponse('Registro eliminado (soft delete)', 201);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Eliminar (soft delete)', $e);
        }
    }

    public function restoreDeleted(Request $request)
    {
        $validator = Validator::make($request->all(), [$this->pkName => $this->pkRule]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $record = $this->model()::withTrashed()->find($request->input($this->pkName));

            if (!$record) return $this->notFoundResponse('No se encontró el registro indicado');

            if (is_null($record->deleted_at)) {
                return response()->json(['message' => 'El registro no está eliminado'], 400);
            }

            $record->restore();

            return $this->successResponse('Registro restaurado', 201);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Restaurar registro', $e);
        }
    }

    public function hardDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [$this->pkName => $this->pkRule]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $record = $this->model()::withTrashed()->find($request->input($this->pkName));

            if (!$record) return $this->notFoundResponse('No se encontró el registro indicado');

            $record->forceDelete();

            return $this->successResponse('Registro eliminado (hard delete)', 201);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Eliminar (hard delete)', $e);
        }
    }
}
