<?php

namespace Modules\TaskAttachments;

use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskAttachmentController extends GenericController
{
    protected string $model = TaskAttachmentModel::class;

    protected array $createRules = [
        'task_id' => 'required|integer|exists:tasks,id',
        'uploaded_by' => 'required|uuid|exists:users,id',
        'file' => 'required|file',
    ];

    protected array $updateRules = [
        'task_id' => 'sometimes|integer|exists:tasks,id',
        'uploaded_by' => 'sometimes|uuid|exists:users,id',
        'file' => 'sometimes|file',
    ];

    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), $this->createRules);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $taskId = $request->task_id;
            $uploadedBy = $request->uploaded_by;
            $file = $request->file('file');

            // 📁 Definimos la ruta dentro del bucket
            // $path = "tasks/{$taskId}/" . uniqid() . '_' . $file->getClientOriginalName();
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $path = "tasks/{$taskId}/{$filename}";

            // ☁️ Subimos el archivo a Supabase
            try {
                // Storage::disk('supabase')->put($path, file_get_contents($file));
                Storage::disk('supabase')->putFileAs("tasks/{$taskId}", $file, $filename);
            } catch (\Exception $e) {
                return $this->serverErrorResponse('Error subiendo el archivo al bucket', $e);
            }

            // 🗃️ Registramos el archivo en la base de datos
            $this->model()::create([
                'task_id' => $taskId,
                'uploaded_by' => $uploadedBy,
                'file' => $path,
            ]);

            return $this->successResponse('Archivo adjunto registrado correctamente');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Registrar Archivo', $e);
        }
    }

    public function viewFile(Request $request)
    {
        try {
            $attachment = $this->model()::findOrFail($request->id);
            $path = $attachment->file;

            /** @var \Illuminate\Filesystem\AwsS3V3Adapter $disk */
            $disk = Storage::disk('supabase');

            // 📥 Obtener el contenido del archivo desde Supabase
            $fileContent = $disk->get($path);

            // 🧩 Determinar tipo MIME automáticamente
            $mimeType = $disk->mimeType($path);

            // 📄 Nombre del archivo (por ejemplo "documento.pdf")
            $fileName = basename($path);

            // 🧠 Determinar si se puede visualizar en navegador
            $inlineTypes = [
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'application/pdf',
                'text/plain',
                'text/html',
                'text/csv'
            ];

            $disposition = in_array($mimeType, $inlineTypes)
                ? 'inline'
                : 'attachment'; // Si no es soportado, forzar descarga

            return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', "{$disposition}; filename=\"{$fileName}\"");
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Obtener archivo', $e);
        }
    }
}
