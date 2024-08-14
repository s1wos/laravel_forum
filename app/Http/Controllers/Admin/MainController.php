<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Message;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $stats = [
            [
                'title' => 'Ветки',
                'count' => Branch::count(),
            ],
            [
                'title' => 'Темы',
                'count' => Theme::count()
            ],
            [
                'title' => 'Сообщения',
                'count' => Message::count()
            ],
            [
                'title' => 'Пользователи',
                'count' => User::count()
            ],
        ];

        return inertia('Admin/Main/Index', compact('stats'));
    }
}
