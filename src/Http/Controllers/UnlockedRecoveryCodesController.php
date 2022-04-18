<?php

namespace Lifeonscreen\Google2fa\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class UnlockedRecoveryCodesController extends Controller
{
    /**
     * @throws ValidationException
     */
    #[ArrayShape(['success' => "bool", 'recovery_codes' => "mixed"])] public function store(Request $request): array
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->input('password'), $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid Password.'],
            ]);
        }

        return [
            'success' => true,
            'recovery_codes' => json_decode(decrypt($request->user()->user2fa->recovery), true),
        ];
    }
}
