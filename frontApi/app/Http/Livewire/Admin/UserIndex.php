<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
// use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class UserIndex extends Component
{
    // use WithPagination;
    // protected $paginationTheme = 'bootstrap';

    public $user_search;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $user_id;
    public $api = 'http://localhost/api/';
    public $error;

    public function paginate($items, $perPage, $page, $options = [], $baseUrl = "/user")
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }

    public function render()
    {
        $token = session()->get('token');
        // dd($token);
        $response = Http::withToken($token)->get($this->api.'users/'.$this->user_search);
        $users = $response->json();
        // dd($users);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $users =  $this->paginate($users['data'], 2, $page);
        return view('livewire.admin.user-index', compact('users'));
    }

    public function cancel()
    {
        $this->error = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function newUser()
    {
        $token = session()->get('token');
        
        $new = Http::withToken($token)->withHeaders(['Accept' => 'application/json', 'Content-Language' => 'tr'])->
        post($this->api.'user', [
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation
                ])->json();
        // dd($new);
        if (isset($new['message'])) {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $new['message']);
            $this->error = $newText;
        }else {
            $this->reset();

            $this->emit('add-user');

            session()->flash('messages', 'Kullanıcı Başarıyla Eklendi');
        }
    }

    public function getUser($id)
    {
        $token = session()->get('token');
        $user = Http::withToken($token)->get($this->api.'user/'.$id);
        $this->error = null;
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->user_id = $user['id'];
    }

    public function updateUser()
    {
        $array = [];
        if (!empty($this->name)) {
            $array['name'] = $this->name;
        }
        if (!empty($this->email)) {
            $array['email'] = $this->email;
        }
        if (!empty($this->password)) {
            $array['password'] = $this->password;
        }
        if (!empty($this->password)) {
            $array['password_confirmation'] = $this->password_confirmation;
        }
        // dd($array);
        $token = session()->get('token');
        $new = Http::withToken($token)->withHeaders(['Accept' => 'application/json',
        'Content-Language' => 'en'])->put($this->api.'user/'.$this->user_id, $array)->json();
        // dd($new);
        if (isset($new['message'])) {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $new['message']);
            $this->error = $newText;
        }else {
            $this->reset();
            $this->emit('update-user');

            session()->flash('messages', 'Kullanıcı Başarıyla Güncellendi');
        }
    }

    public function getUser2($id)
    {
        $token = session()->get('token');
        $user = Http::withToken($token)->get($this->api . 'user/' . $id);
        $this->name = $user['name'];
        $this->user_id = $user['id'];
    }

    public function destroy()
    {
        $token = session()->get('token');
        $user = Http::withToken($token)->delete($this->api.'user/'.$this->user_id);
        $this->emit('delete-user');

        session()->flash('messages', 'Kullanıcı Silindi');
    }
}
