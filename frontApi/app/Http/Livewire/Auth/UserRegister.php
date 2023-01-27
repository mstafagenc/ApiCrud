<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class UserRegister extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $user_id;
    public $error;

    public function render()
    {
        return view('livewire.auth.user-register');
    }

    public function newUser()
    {
        $token = session()->get('token');

        $new = Http::withHeaders(['Accept' => 'application/json', 'Content-Language' => 'tr'])->
        post('http://localhost/api/auth/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ])->json();
        // dd($new);
        if (isset($new['message'])) {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $new['message']);
            $this->error = $newText;
        } else {
            $this->reset();

            $this->emit('add-user');

            session()->flash('message', 'Lütfen giriş yapınız');
            return redirect()->route('login');
        }
    }
}
