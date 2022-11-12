@extends('users.layouts.app')
@section('title') {{"Detail Paket"}}
@endsection

@section('style')
    <style>
        @media (min-width: 219px) and (max-width: 449px) {
            .ybutton-category {
                margin-top: 15px;
            }

            .yjudul {
                margin-top: 10px;
                font-size: 28px;
            }

            .product-desc {
                text-align: justify;
            }

            #message {
                height: 100px;
            }
        }

        @media (min-width: 450px) and (max-width: 767px) {
            .ybutton-category {
                margin-top: 15px;
            }

            .yjudul {
                margin-top: 10px;
                font-size: 28px;
            }

            .product-desc {
                text-align: justify;
            }

            #message {
                height: 100px;
            }
        }

        @media (min-width: 768px) and (max-width: 990px) {
            #message {
                width: 300px;
                height: 100px;
            }

        }

        @media (min-width: 991px) and (max-width: 1199px) {
            #message {
                width: 400px;
                height: 100px;
            }
        }

        @media (min-width: 1200px) {
            #message {
                width: 400px;
                height: 100px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card globalcard">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="detailproduct">
                                    <div class="row">

                                        <div class="imagesliderholder col-md-10 col-lg-8 col-auto  ml-5 ">
                                            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="align-self-center"
                                                             src="{{ asset('storage/img/paket/'.$paket->gambar) }}"
                                                             alt="">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                {{--                                    <button type="button" class="badge custom-badge font-weight-light ybutton-category" data-toggle="test" data-rigger="focus" data-content="Produk ini dibuat dengan metode {{ $product->category }}"--}}
                                {{--                                            data-html="true">--}}
                                {{--                                        {{$product->category}}--}}
                                {{--                                    </button>--}}

                                <h2 class="yjudul">{{ $paket->nama_paket }} </h2>
                                <h6><i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <span>{{ $paket->getKabupaten->nama_kabupaten }}</span></h6>
                                <h6><i class="fa fa-user" aria-hidden="true"></i> <span>Maximal {{ $paket->availability }} Orang</span>
                                </h6>
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="product-price" style="color: orange">
                                            Rp {{ number_format($paket->harga_paket ,0) }}</h4>
                                    </div>
                                    <div class="col-auto">
                                        <h4><i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <span>{{ $paket->durasi }}</span></h4>
                                    </div>
                                </div>

                                <form class="mt-3" method="post" action="/pesan/paket/{{$paket->id_paket}}">
                                    @csrf
                                    <div class="form-row align-items-center">
                                        <div class="col-sm-6 my-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-user"
                                                                                     aria-hidden="true"></i></div>
                                                </div>
                                                <input type="number" min="1" name="jumlah_peserta" class="form-control"
                                                       id="inlineFormInputGroupUsername" placeholder="Jumlah Orang">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-calendar"
                                                                                     aria-hidden="true"></i></div>
                                                </div>
                                                <select name="sesi" class="custom-select form-control">
                                                    <option disabled selected>Pilih Jadwal</option>
                                                    @foreach($sesi as $row)
                                                        <option value="{{$row->id_sesi}}">{{$row->jadwal}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mt-1 align-items-center">
                                        <div class="col-sm-12 my-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-comments"
                                                                                     aria-hidden="true"></i></div>
                                                </div>
                                                <textarea name="pesan" placeholder="Pesan/Pertanyaan Untuk Pemesanan"
                                                          id="" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mt-2 align-items-center">
                                        <div class="col-12 my-1">
                                            @if(Auth::check())
                                                <button type="submit" class="btn essence-btn ml4">Booking Pemesanan
                                                </button>
                                            @else
                                                <a href="#" class="btn essence-btn ml4" data-toggle="modal"
                                                   data-target="#loginModal">Booking Pemesanan</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="row text-center">

                        </div>

                        <div class="row">
                            <div class="mt-5 detailreview">

                                <div class="col-md-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                               role="tab" aria-controls="home" aria-selected="true">
                                                <i class="fa fa-file-text-o mr-2"></i>
                                                <span>Itinerary</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="desc-tab" data-toggle="tab" href="#desc" role="tab"
                                               aria-controls="desc" aria-selected="false">
                                                <i class="fa fa-info mr-2" aria-hidden="true"></i>
                                                <span>Description</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                               role="tab" aria-controls="profile" aria-selected="false">
                                                <i class="fa fa-thumbs-o-up mr-2"></i>
                                                <span>Included not Included</span>
                                            </a>
                                        </li>

                                        @role('customer')
                                        <li class="nav-item">
                                            <a class="nav-link" id="rating-tab" data-toggle="tab" href="#rating"
                                               role="tab" aria-controls="rating" aria-selected="false">
                                                <i class="fa fa-star mr-2"></i>
                                                <span>Ulasan</span>
                                            </a>
                                        </li>
                                        @endrole
                                    </ul>
                                    <div class="tab-content mt-3" id="myTabContent">

                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                             aria-labelledby="home-tab">
                                            <div class="col-9 px-1">
                                                <?php echo $paket->rencana_perjalanan; ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="desc" role="tabpanel"
                                             aria-labelledby="desc-tab">
                                            <div class="col-9 px-1">
                                                <?php echo $paket->deskripsi_paket ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">
                                            <div class="row ml-3">
                                                <div class="col-md-5">
                                                    <h4>Included</h4>
                                                    <ul>
                                                        @foreach($includeds as $included)
                                                            <li><p>{{ $included->keterangan }}</p></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-md-5">
                                                    <h4>Not Included</h4>
                                                    <ul>
                                                        @foreach($not_includeds as $not_included)
                                                            <li><p>{{ $not_included->keterangan }}</p></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        @if (Auth::check())
                                            <div class="tab-pane fade ulasan" id="rating" role="tabpanel"
                                                 aria-labelledby="profile-tab">
                                                {{--                                                <h1>contoh</h1>--}}
                                                <div id="paket-rating" style="margin-bottom: 25px;">
                                                    <paket-rating :paket="{{$paket->id_paket}}"
                                                                  :user="{{ Auth::user()->id }}" :rating="{{$rating}}"/>
                                                </div>
                                            </div>
                                        @endif
                                        @if($paket->reviews === null)
                                            <div class="text-sm-center">
                                                <img src="" alt="">
                                                <b>Belum ada ulasan untuk produk ini</b>
                                                <p>Jadilah yang pertama membeli produk ini dan memberikan ulasan</p>
                                            </div>
                                        @else @foreach ($paket->reviews as $review)
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            Oleh <b> {{ $review->customer->profile->name }}</b> <br>
                                                            <small>{{ date_format($review->created_at,"l, d F Y, h:i:s") }}</small>
                                                            <br> {{ $review->body }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
