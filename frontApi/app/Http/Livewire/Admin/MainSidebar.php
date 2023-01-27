<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class MainSidebar extends Component
{
    public function render()
    {
        $token = session()->get('token');
        $response = Http::withToken($token)->get('http://localhost/api/auth/me');
        $user = $response->json();
        // dd($user);
        return view('livewire.admin.main-sidebar', compact('user'));
    }
    public function userLogout()
    {
        $token = session()->get('token');
        $response = Http::withToken($token)->post('http://localhost/api/auth/logout');
        $users = $response->json();
        session()->forget('token');
        session()->flash('message', $users['messages']);
        return redirect()->route('welcome');
    }
}
