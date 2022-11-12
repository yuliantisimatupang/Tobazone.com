@extends('users.anggotacbt.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Objek Wisata</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Manajemen Informasi</a></li>
                        <li class="breadcrumb-item"><a href="#">Objek Wisata</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    ​
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    @component('components.card')
                        @slot('header')
                            Edit
                        @endslot

                        @slot('body')
                            @if (session('error'))
                                @alert(['type' => 'danger'])
                                {!! session('error') !!}
                                @endalert
                            @endif
                            ​
                            <form role="form" action="{{ route('objekwisata.update', $objekWisata->id) }}" method="POST"  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="nama_objek_wisata">Nama Objek Wisata</label>
                                    <input type="text"
                                           name="nama_objek_wisata"
                                           value="{{ $objekWisata->nama_objek_wisata }}"
                                           class="form-control {{ $errors->has('nama_objek_wisata') ? 'is-invalid':'' }}" id="nama_objek_wisata" required>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category Wisata</label>
                                    <select class="form-control" name="category_id">
                                        @foreach($categorys as $category)
                                            <option value="{{$category->id}}">{{$category->nama_category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <textarea name="lokasi" id="lokasi" cols="5" rows="5" class="form-control {{ $errors->has('lokasi') ? 'is-invalid':'' }}" value="{{$objekWisata->lokasi}}" required="">{{$objekWisata->lokasi}}</textarea>
                                </div>
                            <!-- <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control {{ $errors->has('foto') ? 'is-invalid':'' }}" value="" required="">
                                </div> -->
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" value="{{$objekWisata->longitude}}" class="form-control {{ $errors->has('longitude') ? 'is-invalid':'' }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" value="{{$objekWisata->latitude}}" class="form-control {{ $errors->has('latitude') ? 'is-invalid':'' }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea  name="deskripsi" id="ckedtor" class="ckeditor" cols="5" rows="5" value="{{$objekWisata->deskripsi}}" class="form-control {{ $errors->has('deskripsi') ? 'is-invalid':'' }}" required="">{{$objekWisata->deskripsi}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar</label><br>
                                    <img src="{{asset('Kab/information/ObjekWisata/'.$objekWisata->foto)}}" id="img1" style="max-width: 400px" alt=""><br><br>
                                    <input type="file" id="inpFile" name="inpFile" onchange="ubahGambar()">
                                </div>
                                @endslot
                                @slot('footer')
                                    <div class="card-footer">
                                        <button class="btn btn-info"><i class="fa fa-edit"></i> Update</button>
                                    </div>
                            </form>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function ubahGambar() {
            readURL();
        }

        function readURL() {
            if (inpFile.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#img1").attr("src", e.target.result);

                }
                reader.readAsDataURL(inpFile.files[0]);
            }
        }
    </script>
@endsection