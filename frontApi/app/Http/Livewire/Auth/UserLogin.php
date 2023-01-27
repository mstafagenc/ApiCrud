<?php

namespace App\Http\Livewire\Auth;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class UserLogin extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.auth.user-login');
    }

    public function userLogin()
    {
        $response = Http::withHeaders(['Accept' =>'application/json', 'Content-Language' => 'tr'])->
        post('http://localhost/api/auth/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);
        $users = $response->json();
        
        if (empty($users['message'])) {
            session()->put('token', $users["access_token"], 60 * 24 * 7);
            session()->flash('messages', 'Giriş başarılı');
            $message =  'Kullanıcı Girişi Başarılı.';
            $alert = 'success';
            $status = true;
            return redirect()->route('users.index');
        } else {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $users['message']);
            session()->flash('message', $newText);
            $message =  'Kullanıcı Girişi Başarısız.';
            $alert = 'error';
            $status = false;
        }

        $this->reset();
        $this->dispatchBrowserEvent('user-login', [
            "closeButton" => false,
            "debug" => false,
            "newestOnTop" => false,
            "progressBar" => false,
            "positionClass" => "toast-top-right",
            "preventDuplicates" => false,
            "onclick" => null,
            "showDuration" => "300",
            "hideDuration" => "1000",
            "timeOut" => "5000",
            "extendedTimeOut" => "1000",
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut",
            'message' =>  $message,
            'alert' =>  $alert,
            'status' => $status,
        ]);
    }
}
