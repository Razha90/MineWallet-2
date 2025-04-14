<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinController extends Controller
{
    public function __construct() {
        $user = auth()->user();
        if ($user->pin == null) {
            return redirect()->route('settings.profile');
        }
    }
}
