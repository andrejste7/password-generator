<?php

namespace App\Http\Controllers;

use App\Helpers\PasswordGenerator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PasswordGeneratorController extends Controller
{
    private PasswordGenerator $passwordGenerator;

    public function __construct(PasswordGenerator $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

    public function index(): View
    {
        return view('password-generator-view');
    }

    public function generatePassword(Request $request): JsonResponse
    {
        ['success' => $success, 'error_list' => $error_list, 'password' => $password] = $this->passwordGenerator->generate(
            $request->input('password_length'),
            $request->input('password_affix_list'),
        );

        return Response::json(
            array(
                'success' => $success,
                'password' => $password,
                'error_list' => $error_list,
            )
        );
    }
}
