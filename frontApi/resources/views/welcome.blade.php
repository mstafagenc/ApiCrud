<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anasayfa</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
   @livewireStyles
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @livewire('user.user-navbar')
    <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
    <div class="container mt-4">
         @foreach($jsonData as $item)
            <div class="row p-3 mb-4 bg-secondary text-white rounded"  x-data="{ open{{ $loop->iteration }}: false }">
                <div class="col-11 ps-4 "><h4>{{ $item['name']  }} Kulanıcısına Ait Makaleler</h4> </div>
                <div class="col-1 ">
                    <div >
                        <a href ="#"   @click="open{{ $loop->iteration }} = true">
                            <i class="fas fa-caret-down" x-show="open{{ $loop->iteration }} == false"></i>
                            <i class="fas fa-caret-up" x-show="open{{ $loop->iteration }} == true"></i>
                        </a> 
                    </div>
                </div>               
                <!--  -->
                <div @click.outside="open{{ $loop->iteration }} = false" x-show="open{{ $loop->iteration }}">
                        @foreach($item['crud_apis'] as $i)
                                <h5 class ="text-center"><strong class="mr-auto">{{ $loop->iteration }}.</strong>{{ $i['title'] }}</h5><br>
                                <div class="m-4" style="display: flex">
                                    <div class="col-3">
                                        @if($i['image'])
                                            <a href="{{ $url .$i['image'] }}" target="_blank">
                                                <img src="{{ $url . $i['image'] }}" class="img-fluid">
                                            </a>
                                        @else                                           
                                            <img src="https://picsum.photos/2{{ $loop->iteration }}7" alt="" class="img-fluid">
                                        @endif                                           
                                    </div>
                                    <div class="">
                                        <p class="">
                                            {!! $i['desc'] !!}
                                        </p>
                                    </div>
                                </div>
                        @endforeach
                </div>         
            </div>
        @endforeach
        {{-- {{ $users->links() }} --}}
    </div>
  <!-- /.content-wrapper -->

  
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- alpinejs -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@livewireScripts
</body>
</html>