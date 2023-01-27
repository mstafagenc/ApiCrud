<div>
    <form wire:submit.prevent="newUser">
        <div class="modal-header justify-content-center">
            <h4 class="modal-title">KAYIT OL</h4>
        </div>
        <div class="modal-body">
            @if(isset($error))
            <div class="alert alert-danger text-center">{{$error}}</div>
            @endif
            <div class="mb-3">
                <label for="IpputFullname" class="form-label">Ad Soyad</label>
                <input wire:model="name" type="text" class="form-control" id="IpputFullname">
            </div>
            <div class="mb-3">
                <label for="IpputEmail" class="form-label">e-mail</label>
                <input wire:model="email" type="email"class="form-control" id="IpputEmail">
            </div>
            <div class="mb-3">
                <label for="IpputPassword" class="form-label">Şifre</label>
                <input wire:model="password" type="password"class="form-control" id="IpputPassword">
            </div>
            <div class="form-group justify-content-center">
                <label for="Ipputpassword_confirmation" class="form-label">Şifreyi Onayla</label>
                <input wire:model="password_confirmation" type="password"class="form-control" id="Ipputpassword_confirmation">
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success">KAYIT OL</button>
        </div>
    </form>
</div>
