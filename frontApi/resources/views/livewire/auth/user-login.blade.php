<div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Giriş yapınız</p>
      @if (session()->has('message'))
        <div class="alert alert-info">{{session('message')}}</div>
      @endif

      <form wire:submit.prevent="userLogin">
          @error('email')
          <div class="text-danger">{{$message}}</div>
          @enderror
        <div class="input-group mb-3">
          <input wire:model="email" type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('password')
          <div class="text-danger">{{$message}}</div>
        @enderror
        <div class="input-group mb-3">
          <input wire:model="password" type="password" class="form-control" placeholder="Şifre">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">Giriş</button>
          </div>
          <div class="col-12 mt-2">
            <a href="{{route('register')}}" class="btn btn-primary btn-block">kayıt ol</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <!-- /.login-card-body -->
    @section('foot')
        <script>
            window.addEventListener('user-login', function (e) {
                toastr.options = e.detail;
                toastr[e.detail.alert](e.detail.message)

                if(e.detail.status){
                    setTimeout(function () {
                        window.location.href = '{{route('welcome')}}';
                    },1000);
                }
            })
        </script>
    @endsection
  </div>

