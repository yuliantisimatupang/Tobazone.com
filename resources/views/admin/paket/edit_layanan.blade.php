@extends('admin.layouts.app')
@section('title') {{ "Create Paket" }}
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{Request::segment(3)=== 'add' ? 'Tambah Paket Wisata' : 'Edit Paket Wisata'}}</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="layanans">Layanan yang Ada</label>
                                <div class="mb-3">
                                    {{--                                mulai loop--}}
                                    @foreach($paket->getPaketLayanan as $row)
                                        <div class="row" id="layanans">
                                            <div class="col-10">
                                                <br>
                                                <input type="text" value="{{$row->nama_layanan}}" class="form-control"
                                                       placeholder="Layanan" disabled required>
                                                {{--                                                <p class="text-danger">{{$error->first('included_1')}}</p>--}}
                                            </div>
                                            <div class="col-2">
                                                <br>
                                                <a href="{{route('admin.paket.hapus.layanan',['id_layanan'=>$row->id,'id_paket'=>$paket->id_paket])}}"
                                                   class="btn btn-danger"><i class="fa fa-minus"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{--                                akhir loop--}}
                                </div>
                            </div>
                            <hr>
                            <hr>
                            <br>
                            <form action="{{ route('admin.paket.update.layanan',$paket->id_paket) }}" method="post" id="store-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="layanan">Tambah Layanan
                                        <button type="button" onclick="tambah()" class="btn btn-success">
                                            <i class="fa fa-plus"></i></button>
                                    </label>
                                    <div class="mb-3" id="item_to_add">

                                    </div>
                                    <input id="jlh_layanan" type="number" name="jlh_layanan" value="<?= $c ?>" hidden></input>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button onclick="return confirm('Apakah ingin mengedit data layanan wisata untuk paket ini?')" type="submit" class="btn btn-primary">Edit</button>
                                    <a href="{{route('admin.paket.editChoice',$paket->id_paket)}}" class="btn btn-danger">Batal</a>
                                </div>
                            </form>

                            <script>
                                var c = <?= $c ?>;

                                function tambah() {
                                    c++;
                                    var html = '';
                                    html += '<div class="row" id="new_layanan_'+c+'"><div class="col-md-10"><br>';
                                    html += '<select class="form-control custom-select" name="layanan_'+c +'" required>';
                                    html += '<option selected="" disabled="">Pilih Layanan Wisata</option><?php echo $options; ?>';
                                    html += '</select>';
                                    html += '</div>';
                                    html += '<div class="col-md-2"><br>';
                                    html += '<button type="button" onclick="remove()" class="btn btn-danger"><i class="fa fa-minus"></i></button>';
                                    html += '</div></div>';
                                    $("#item_to_add").append(html);
                                    $('#jlh_layanan').val(c);
                                }

                                function remove() {
                                    $('#new_layanan_'+c).remove();
                                    c--;
                                    $('#jlh_layanan').val(c);}
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
