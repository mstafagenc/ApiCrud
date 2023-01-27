<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container">
            <div>
              <h1 class="text-center">KULANICILAR</h1>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  @if(session()->has('messages'))
                    <div class="alert alert-success m-3">{{session('messages')}}</div>
                  @endif
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="card-title">Tüm Kullanıcılar</h3>
                      </div>
                      <div class="col-auto">
                        <button wire:click.prevent="cancel()" class="btn btn-outline-success" data-toggle="modal" data-target="#modal-default">Yeni Kullanıcı Ekle</button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <input wire:model="user_search" type="text" class="form-control mt-3" placeholder="KULLANICI ARA">
                      </div>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ID</th>
                          <th>Ad Soyad</th>
                          <th>Email</th>
                          <th>Oluşturma Tarihi</th>
                          <th>İşlemler</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{$user['id']}}</td>
                          <td>{{$user['name']}}</td>
                          <td>{{$user['email']}}</td>
                          <td>{{$user['created_at']}}</td>
                          <td>
                            <a wire:click="getUser({{$user['id']}})" href="#" class="text-primary" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i></a>
                            ---
                            <a wire:click="getUser2({{$user['id']}})"  href="#" class="text-danger" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                      {{ $users->links() }}
                  </div>
                </div>
              </div>
            </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
      <!-- 1.modal -->
      <div wire:ignore.self class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
              <form wire:submit.prevent="newUser">
                <div class="modal-header">
                  <h4 class="modal-title">Yeni Kullanıcı Ekle</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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
                  <div class="form-group">
                      <label for="Ipputpassword_confirmation" class="form-label">Şifreyi Onayla</label>
                      <input wire:model="password_confirmation" type="password"class="form-control" id="Ipputpassword_confirmation">
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                  <button type="submit" class="btn btn-success">Kulanıcı Oluştur</button>
                </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- 2.modal -->
      <div wire:ignore.self class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
              <form wire:submit.prevent="updateUser">
                <div class="modal-header">
                  <h4 class="modal-title">Kullanıcı Güncelle ({{$name}})</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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
                      <input wire:model="email" type=""class="form-control" id="IpputEmail">
                  </div>
                  <div class="mb-3">
                      <label for="IpputPassword" class="form-label">Şifre</label>
                      <input wire:model="password" type="password"class="form-control" id="IpputPassword">
                  </div>
                  <div class="form-group">
                      <label for="Ipputpassword_confirmation" class="form-label">Şifreyi Onayla</label>
                      <input wire:model="password_confirmation" type="password"class="form-control" id="Ipputpassword_confirmation">
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                  <button type="submit" class="btn btn-success">Kulanıcı Güncelle</button>
                </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- 3.modal -->
      <div wire:ignore.self class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form wire:submit.prevent="destroy">
                <div class="modal-header">
                  <h4 class="modal-title text-center">KULANICI SİLME ({{$name}})</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3 class="text-danger">Kulanıcı silinsin mi?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                  <button  type="submit" class="btn btn-danger">Kulanıcı Sil</button>
                </div>
            </form>
            </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      @section('foot')
        <script>
          window.livewire.on('add-user',()=>{
            $('#modal-default').modal('hide');
          });

          window.livewire.on('update-user',()=>{
            $('#modal-edit').modal('hide');
          });

          window.livewire.on('delete-user',()=>{
            $('#modal-delete').modal('hide');
          });
        </script>
      @endsection
</div>
