<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function render($request, Throwable $e)
    {
        if (str_contains($e->getMessage(), 'Unauthenticated')) {
            Log::error($e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine() . json_encode($e->getTrace()));
            return redirect('/');
        }

        if (str_contains($e->getMessage(), 'Unauthorized')) {
            Log::error($e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine() . json_encode($e->getTrace()));
            if($request->ajax())
                return response()->json(['success' => false, 'message' => __('ajax.permission.warning') . ' <br> Incident ID: ' . $request->incident_id, 'type' => 'Error!'], 200);
            else
                return response()->view('errors.403');

        }

        if ($e instanceof AuthorizationException) {
            return parent::render($request, $e);
        }

        if ($e instanceof ValidationException) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    if (str_contains($message, 'has already been taken')) {
                        // Log the unique validation error
                        Log::error('Incident ID: ' . $request->incident_id . ' - ' . $e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine() . json_encode($e->getTrace()));
                    }
                }
            }
            return parent::render($request, $e);
        }
        Log::error('Incident ID: ' . $request->incident_id . ' - ' . $e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine() . json_encode($e->getTrace()));
        if($request->ajax())
            return response()->json(['success' => false, 'message' => __('exception.error') . ' ' . $request->incident_id, 'type' => 'Error!'], 200);
        else {
            return response()->view('errors.general');

        }
    }
}
