<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use App\Models\Sistema\TransportUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

trait ApiResponser
{
    protected function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function errorController($message = "Error en el controlador", $code = 422)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function errorTransaccion($message = "Error en la transacción", $code = 423)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection, 'code' => $code], $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance, 'code' => $code], $code);
    }
}
