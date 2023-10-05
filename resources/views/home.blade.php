@extends('adminlte::page')

    @section('title', 'dashboard admin')

    @section('content_header')
        <h1 class="m-0 text-dark">DASHBOARD ADMIN</h1>
    @stop

    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-0">
                            <h2>WELCOME ADMIN</h2>
                             <hr>
                            Silahkan melakukan proses untuk pengolahan berita online
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-0">
                            <h3>History proses pengolahan data berita</h3>
                             <hr>
                            Bagian ini nanti untuk menampilkan data trigger dari tabel berita
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @stop

        @section('plugins.Sweetalert2', true)
        @section('plugins.Pace', true)
        @section('js')
        @if (session('success'))
        <script type="text/javascript">
            Swal.fire(
                'Sukses!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif
    <script>
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
        }, false);
    </script>
@stop