<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;

class GponOnusController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda repositorio de gponons.
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    protected \App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository;

    /**
     * Iniciando construtor.
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    public function __construct(\App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository)
    {
        $this->gponOnusRepository = $gponOnusRepository;
    }

    public function index()
    {
        try {
            return $this->successResponse($this->gponOnusRepository->getOnus());
        } catch (\App\Exceptions\Analytics\AuthException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}