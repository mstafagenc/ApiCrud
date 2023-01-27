<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Http;

class UserArticle extends Component
{
    use WithFileUploads;
    public $title;
    public $oldTitle;
    public $desc;
    public $image;
    public $oldImage;
    public $deleteOldImage;
    public $user_id;
    public $api = 'http://localhost/api/';
    public $url = 'http://localhost/';
    public $error;
    public $iteration;

    public function files()
    {
        $response = $this->http();
        if ($this->image instanceof TemporaryUploadedFile) {
            $fileContent = file_get_contents($this->image->getRealPath());
            $photo = $response->attach('attachment', $fileContent, $this->title . '.jpg')->post($this->api . 'files')->json();
            $path = $photo['img'];
        }
        return $path;
    }

    public function http()
    {
        $token = session()->get('token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Language' => 'en'
        ]);
        return $response;
    }

    public function render()
    {
        $token = session()->get('token');
        $response = Http::withToken($token)->get($this->api . 'items');
        $user = $response->json();
        // dd($user);
        return view('livewire.user.user-article', compact('user'));
    }

    public function clear()
    {
        $this->resetValidation();
        $this->image = null;
        $this->iteration++;
        $this->error = null;
        $this->oldImage = null;
        $this->title = '';
        $this->desc = '';
    }

    public function newArticle($id)
    {
        $response = $this->http();
        if (!empty($this->image)) 
            $path = $this->files();
        
        $array = [];
        if (!empty($path)) {
            $array['image'] = $path;
        }
        $array['user_id'] = $id;
        $array['title'] = $this->title;
        $array['desc'] = $this->desc;

        $item = $response->post($this->api . 'item', $array)->json();
        // $user = $response;
        // dd($user);
        
        if (isset($item['message'])) {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $item['message']);
            $this->error = $newText;
        } else {
            $this->reset();

            $this->emit('add-article');

            session()->flash('messages', 'Makale Başarıyla Eklendi');
        }
    }

    public function getArticle($id)
    {
        $this->clear();
        $token = session()->get('token');
        $user = Http::get($this->api . 'item/' . $id)->json();
        // dd($user);
        $this->error = null;
        $this->title = $user['title'];
        $this->oldTitle = $user['title'];
        $this->desc = $user['desc'];
        if($user['image'])
            $this->oldImage = $this->url . $user['image'];
        else
            $this->oldImage = null;
        $this->user_id = $user['id'];
        $this->deleteOldImage = $user['image'];
    }

    public function updateArticle()
    {
        if (!empty($this->image))
            $path = $this->files();

        $response = $this->http();

        $array = [];
        if (!empty($this->title)) {
            $array['title'] = $this->title;
        }
        if (!empty($this->desc)) {
            $array['desc'] = $this->desc;
        }
        if (!empty($path) && $this->title != $this->oldTitle) {
            $array['image'] = $path;
            // dd($path);
            if (!empty($this->deleteOldImage))
                $array['deleteOldImage'] = $this->deleteOldImage;
        }
        // dd($array);
        
        $new = $response->put($this->api . 'item/' . $this->user_id, $array)->json();
        // dd($new);
        if (isset($new['message'])) {
            $newText = preg_replace("/\(and \d+ more errors?\)/", "", $new['message']);
            $this->error = $newText;
        } else {
            $this->reset();
            $this->emit('update-article');

            session()->flash('messages', 'Makale Başarıyla Güncellendi');
        }
    }

    public function getArticle2($id)
    {
        $token = session()->get('token');
        $user = Http::get($this->api . 'item/' . $id)->json();
        $this->title = $user['title'];
        $this->user_id = $user['id'];
    }

    public function destroy()
    {
        $token = session()->get('token');
        $user = Http::delete($this->api . 'item/' . $this->user_id);
        $this->emit('delete-article');

        session()->flash('messages', 'Makale Silindi');
    }
}
