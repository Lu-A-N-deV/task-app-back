<?php

namespace Modules\Genres;

use App\Http\Controllers\GenericController;

class GenreController extends GenericController
{
    protected string $model = GenreModel::class;

    protected array $createRules = [
        'key' => 'required|string|max:255|unique:genres,key',
        'name' => 'required|string|max:255',
    ];

    protected array $updateRules = [
        'key' => 'sometimes|string|max:255|unique:genres,key',
        'name' => 'sometimes|string|max:255',
    ];
}
