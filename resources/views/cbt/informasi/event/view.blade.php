@extends('users.anggotacbt.app')
@section('content')
    <div class="jumbutron mt-50 ml-2 mr-2">
        <div class="jumbotron text-white jumbotron-image shadow"
             style="height:500px;background-image: url({{'/Kab/information/Event/'.$event->foto}});background-size:2000px 1000px ;background-repeat: no-repeat">
            <h1 class="mb-4 text-white">
                <span class="badge badge-light">{{$event->nama_event}}</span>
            </h1>
            <p class="mb-4">
            <h4><span class="badge badge-warning">Event</span></h4><br>
            <h4><span class="badge badge-primary">{{$event->tgl_awal}} - {{$event->tgl_akhir}}</span></h4><br>
            </p>
        </div>
    </div>


    <div class="row ml-2 mr-2">
        <div class="col-md-8">

            <?php echo $event->deskripsi ?>
        </div>
    </div>
@endsection