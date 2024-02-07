<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public static function index()
    {
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $documents = Document::whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('updated_at')
            ->get();

        $users = User::whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('updated_at')
            ->get();

        return view('dashboard.index', [
            "users" => $users,
            "documents" => $documents
        ]);
    }
}
