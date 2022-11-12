@extends('users.layouts.app')
@section('title') {{ "Product Detail" }}
@endsection

@section('style')
    <style>
        @media (min-width:219px) and (max-width: 449px){
            .ybutton-category{
                margin-top: 15px;
            }
            .yjudul{
                margin-top: 10px;
                font-size: 28px;
            }
            .product-desc{
                text-align: justify;
            }
            #message{
                height: 100px;
            }
        }
        @media (min-width:450px) and (max-width: 767px){
            .ybutton-category{
                margin-top: 15px;
            }
            .yjudul{
                margin-top: 10px;
                font-size: 28px;
            }
            .product-desc{
                text-align: justify;
            }
            #message{
                height: 100px;
            }
        }
        @media (min-width:768px) and (max-width: 990px){
            #message{
                width: 300px;
                height: 100px;
            }

        }
        @media (min-width:991px) and (max-width: 1199px){
            #message{
                width: 400px;
                height: 100px;
            }
        }
        @media (min-width:1200px){
            #message{
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

                  <div class="col-lg-auto col-md-auto col-sm-auto pr-0 smallimageholder">
                    <ul class="nav nav-pills nav-justified smallimage ">
                      @foreach (json_decode($product->images) as $idx => $image) @if ($loop->first)
                      <li class="mb-2" data-target="#myCarousel" data-slide-to="{{ $idx }}" class="active">
                        <img src="{{ '/images/' . $image }}" alt="">
                      </li>
                      @else
                      <li class="mb-2" data-target="#myCarousel" data-slide-to="{{ $idx }}">
                        <img src="{{ '/images/' . $image }}" alt="">
                      </li>
                      @endif @endforeach
                    </ul>
                  </div>
                  <div class="imagesliderholder col-md-10 col-lg-8 col-auto  ml-0 ">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">


                      <div class="carousel-inner">
                        @foreach (json_decode($product->images) as $image) @if ($loop->first)
                        <div class="carousel-item active">
                          <img class="align-self-center" src="{{ '/images/' . $image }}" alt="">
                        </div>
                        @else
                        <div class="carousel-item">
                          <img src="{{ '/images/' . $image }}">
                        </div>
                        @endif @endforeach
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </div>

            @if($product->cat_product == "ulos")
            <div class="col-md-6">
              <button type="button" class="badge custom-badge font-weight-light ybutton-category" data-toggle="test" data-rigger="focus" data-content="Produk ini dibuat dengan metode {{ $product->category }}"
                data-html="true">
                {{$product->category}}
              </button>

              <h2 class="yjudul">{{ $product->name }} </h2>
              <h4 class="product-price" style="color: orange">Rp {{ number_format($product->price ,0) }}</h4>
              <p class="product-desc">{{$product->description}}</p>
              <p class="product-desc">Ulos ini berasal dari daerah {{$product->asal}}</p>
              <h6 class="product-desc"> Berat: {{ json_decode($product->specification)->weight}} gram</h6>


              <!-- @if($product['cat_product'] == "ulos") -->
              <h6 class="product-desc"> Ukuran: {{ json_decode($product->specification)->dimention }}</h6>
              <!-- @elseif($product['cat_product'] == "pakaian") -->
              <!-- <h6 class="product-desc"> Ukuran : {{ json_decode($product->specification)->size }}</h6> -->
              <!-- @elseif($product['cat_product'] == "makanan") -->
              <!-- <h6 class="product-desc"> Ukuran Pembungkus: {{ json_decode($product->specification)->size_pack }}</h6> -->
              <!-- @elseif($product['cat_product'] == "aksesoris") -->
              <!-- <h6 class="product-desc"> Ukuran : {{ json_decode($product->specification)->size }}, Warna : {{ $product->color }} </h6> -->
              <!-- @elseif($product['cat_product'] == "obat")
                  @if(json_decode($product->specification)->jenis == "Padat")
                    <h6 class="product-desc"> - </h6>
                  @elseif(json_decode($product->specification)->jenis == "Cair")
                  <h6 class="product-desc"> Volume : {{ $product->color }} </h6>
                  @endif

              @endif -->
            @elseif($product['cat_product'] == "pakaian" )
            <div class="col-md-7">
              <button type="button" class="ybutton-category badge custom-badge font-weight-light" data-toggle="test" data-rigger="focus" data-content="<b>pakaian {{ $product->category }}"
                data-html="true">
                {{$product->category}}
              </button>

              <h3 class="yjudul">{{ $product->name }} </h3>
              <h4 class="product-price" style="color: orange">Rp {{ number_format($product->price ,0) }}</h4>
              <p class="product-desc">{{$product->description}}</p>
              <p class="product-desc">Dibuat di {{ $product->asal }}</p>
              <h6 class="product-desc"> Berat {{ json_decode($product->specification)->weight}} gram</h6>
              <h6 class="product-desc"> Ukuran Tersedia : {{ json_decode($product->specification)->size }}</h6>
            @elseif($product['cat_product'] == "makanan" )
            <div class="col-md-7">
              <button type="button" class="badge custom-badge font-weight-light" data-toggle="test" data-rigger="focus" data-content="<b>Makanan {{ $product->category }}</b>"
                data-html="true">
                {{$product->category}}
              </button>

              <h2>{{ $product->name }} </h2>
              <h4 class="product-price" style="color: orange">Rp {{ number_format($product->price ,0) }}</h4>
              <p class="product-desc">{{$product->description}}</p>
              @if($product['cat_product'] == "ulos")
              <p class="product-desc">Produk ini dibuat dengan metode {{$product->category}}</p>
              @elseif($product['cat_product'] == "pakaian")
              <p class="product-desc">Produk ini adalah yang terbaik untuk {{$product->category}}</p>
              @elseif($product['cat_product'] == "makanan")
              <p class="product-desc">Umur simpan : {{ json_decode($product->specification)->umur_simpan}}</p>
              @elseif($product['cat_product'] == "aksesoris")
              <p class="product-desc">Produk ini dibuat dengan  {{$product->category}}</p>
              @elseif($product['cat_product'] == "obat")
              <p class="product-desc">Obat ini merupakan obat {{$product->category}}</p>
              @endif

              <h6 class="product-desc"> Berat {{ json_decode($product->specification)->weight}} gram</h6>


              @if($product['cat_product'] == "ulos")
              <h6 class="product-desc"> Ukuran {{ json_decode($product->specification)->dimention }}</h6>
              @elseif($product['cat_product'] == "pakaian")
              <h6 class="product-desc"> Ukuran : {{ json_decode($product->specification)->size }}</h6>
              @elseif($product['cat_product'] == "makanan")
              <h6 class="product-desc"> Ukuran Pembungkus: {{ json_decode($product->specification)->size_pack }}</h6>
              @elseif($product['cat_product'] == "aksesoris")
              <h6 class="product-desc"> Ukuran : {{ json_decode($product->specification)->size }}, Warna : {{ $product->color }} </h6>
              @elseif($product['cat_product'] == "obat")
                  @if(json_decode($product->specification)->jenis == "Padat")
                    <h6 class="product-desc"> - </h6>
                  @elseif(json_decode($product->specification)->jenis == "Cair")
                  <h6 class="product-desc"> Volume : {{ $product->color }} </h6>
                  @endif

              @endif
            @elseif($product['cat_product'] == "aksesoris" )
            <div class="col-md-7">
              <button type="button" class="ybutton-category badge custom-badge font-weight-light" data-toggle="test" data-rigger="focus" data-content="Aksesoris ini merupakan {{ $product->category }}"
                data-html="true">
                {{$product->category}}
              </button>

              <h2 class="yjudul">{{ $product->name }} </h2>
              <h4 class="product-price" style="color: orange">Rp {{ number_format($product->price ,0) }}</h4>
              <p class="product-desc">{{$product->description}}</p>
              <p class="product-desc">Aksesoris berasal dari {{$product->asal}}</p>
              <h6 class="product-desc"> Berat {{ json_decode($product->specification)->weight}} gram</h6>
              <h6 class="product-desc"> Ukuran : {{ json_decode($product->specification)->size }}, Warna Dominan : {{ $product->color }} </h6>

            @elseif($product['cat_product'] == "obat" )
            <div class="col-md-7">
              <button type="button" class="ybutton-category badge custom-badge font-weight-light" data-toggle="test" data-rigger="focus" data-content="<b> Wujud obat adalah {{ json_decode($product->specification)->jenis }} </b>"
                data-html="true" >
                {{ json_decode($product->specification)->jenis}}
              </button>

              <h2 class="yjudul">{{ $product->name }} </h2>
              <h4 class="product-price" style="color: orange">Rp {{ number_format($product->price ,0) }}</h4>
              <p class="product-desc">{{$product->description}}</p>
              <p class="product-desc">Obat ini merupakan obat khas dari {{$product->asal}}</p>
              <h6 class="product-desc"> Berat {{ json_decode($product->specification)->weight}} gram</h6>
              @if(json_decode($product->specification)->jenis == "Padat")
                <h6 class="product-desc"> ukuran kemasan : {{ $product->color }} </h6>
              @elseif(json_decode($product->specification)->jenis == "Cair")
                <h6 class="product-desc"> Volume : {{ $product->color }}ml </h6>
              @endif
            @endif
                <label for="message">Pesan untuk penjual</label>
                <textarea class="form-control" id="message1" v-model="message"></textarea>


                <br>
              @role('merchant')
              @if(Auth::user()->id == $product->user_id)
              <div class="cart-fav-box d-flex align-items-center mt-4">
                <a href="{{ url('/products/edit', $product->id) }}" class="btn essence-btn">Ubah</a>
                <!-- <form action="{{ url('/products/delete', $product->id)}}" method="POST">
                  {{ csrf_field() }} -->
                  <button type="submit" class="btn essence-btn ml-4" data-toggle="modal" data-target="#deleteConfirmation">Hapus</button>
                <!-- </form> -->
              </div>
              @endif


              <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteConfirmationLabel">Konfirmasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('/products/delete', $product->id)}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p>Apakah Anda Yakin Mau Menghapus?</p>
                                </div>
                                <!-- <input type="hidden" name="id_product" id="cat_prod" value=""> -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

              @else @if(Auth::check())
              <div class="row">

              <div class="col-md-5">
              <div id="add-to-cart-button">
                <add-to-cart-button :max-unit="{{$product->stock}}" :user-id="{{Auth::user()->id}}" :product-id="{{$product->id}}" :message="message" />
              </div>
              </div>

              <!-- <div class="col-md-6">
              <div id="add-to-wishlist-button">
                <add-to-wishlist-button :max-unit="{{$product->stock}}" :user-id="{{Auth::user()->id}}" :product-id="{{$product->id}}" />
              </div>
              </div> -->

              </div>
              <!-- <div id="add-to-cart-button">
                <add-to-cart-button :max-unit="{{$product->stock}}" :user-id="{{Auth::user()->id}}" :product-id="{{$product->id}}" />~
              </div> -->


              @else
              <div>
                <button class="btn essence-btn ml4 " data-toggle="modal" data-target="#loginModal"> Login Untuk Memesan Barang</button>
              </div>
              @endif @endrole

            </div>
          </div>

          <div class="row">
            <div class="mt-5 detailreview">

              <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                      <i class="fa fa-file-text-o mr-2"></i>
                      <span>Deskripsi</span>
                    </a>
                  </li>
                  @role('customer')
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                      <i class="fa fa-thumbs-o-up mr-2"></i>
                      <span>Ulasan</span></a>
                    </a>
                  </li>
                  @endrole

                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                  <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                    {{ $product->description }}
                  </div>

                  <div class="tab-pane fade ulasan" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if (Auth::check())
                      <div id="user-rating" style="margin-bottom: 25px;">
                        <user-rating :product="{{ $product->id }}" :user="{{ Auth::user()->id }}" :rating="{{ $product->rating }}"/>
                      </div>
                    @endif
                    @if($product->review === null)
                    <div class="text-sm-center">
                      <img src="" alt="">
                      <b>Belum ada ulasan untuk produk ini</b>
                      <p>Jadilah yang pertama membeli produk ini dan memberikan ulasan</p>
                    </div>
                    @else @foreach ($product->reviews as $review)
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
</div>
@role('customer')
<div id="new-product">
  @if(Auth::check())
  <new-products-suggest :product-id="'{{$product->id}}'" :user-id="{{Auth::user()->id}}" :title="'Produk Sejenis'" :suggest="'{{ $product['cat_product'] }}'"/> @else
  <new-products-suggest :product-id="'{{$product->id}}'" :title="'Produk Lain'" :suggest="'{{ $product['cat_product'] }}'" /> @endif
</div>
@endrole
@include('users.auth.login_modal')
@endsection
