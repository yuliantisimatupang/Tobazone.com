@extends('users.layouts.app')
@section('title') {{ "Homestay" }}
@endsection

@section('content')
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="card container bayangan-bawah"
             style="background-color: #FFFAF4; margin-bottom: -20px">
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h4>{{$homestays['homestays']->name}}</h4>
                </div>
                {{--
                <div class="col-md-6" align="right">--}}
                    {{-- <p style="color: #FF8311">Harga Kamar/Hari </p>--}}
                    {{--
                </div>
                --}}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>{{$homestays['homestays']->address}}</p>
                </div>
                {{--
                <div class="col-md-6" align="right">--}}
                    {{-- <h4 style="color: #FF8311">Rp. {{$homestays['homestays']->price}}</h4>--}}
                    {{--
                </div>
                --}}
            </div>
            <br>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-lg-8 bg-white pt-3 pl-3 mb-3 img-thumbnail bayangan">
                <form action="{{ url('/homestay/pesanBulk/') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="col-lg-6">
                                <p style="margin-bottom: -5px; font-weight: bolder">Check in</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar"
                                                                         aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <input type="date" name="checkIn" required class="form-control"
                                           id="inlineFormInputGroup">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p style="margin-bottom: -5px; font-weight: bolder">Durasi</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-moon-o"
                                                                         aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <input type="number" min="1" required class="form-control"
                                           name="durasi" id="inlineFormInputGroup">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p style="margin-bottom: -5px; font-weight: bolder">Tamu</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-users"
                                                                         aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <input type="number" min="1" required name="totalRoom"
                                           class="form-control" id="inlineFormInputGroup">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-12 mt-4 mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <b> Nama Kamar</b>
                            </div>
                            <div class="col-md-2">
                                <b> Kategori</b>
                            </div>
                            <div class="col-md-4">
                                <b> Fasilitas</b>
                            </div>
                            <div class="col-md-2">
                                <b> Harga</b>
                            </div>
                            <div class="col-md-2">
                                <b> Aksi</b>
                            </div>
                        </div>
                        <div class="row">
                            <?php $counts = 0; $available=0; ?>
                            @foreach ($homestays['kamar'] as $kamar)
                            <?php $counts++; ?>
                            <div class="col-md-2">
                                <b><p class="mt-3">Kamar {{$counts}}</p></b>
                            </div>
                            <div class="col-md-2">
                                <p class="mt-3">{{$kamar->kategori}}</p>
                            </div>
                            <div class="col-md-4 mt-3">
                                @if(str_contains($kamar->facilities,'Wifi'))
                                <p><i class="fa fa-wifi" aria-hidden="true"></i>&nbsp;&nbsp;Wifi</p>
                                @endif
                                @if(str_contains($kamar->facilities,'Pemanas'))
                                <p><i class="fa fa-coffee" aria-hidden="true"></i>&nbsp;&nbsp;Pemanas
                                </p>
                                @endif
                                @if(str_contains($kamar->facilities,'Kamar mandi'))
                                <p><i class="fa fa-bath" aria-hidden="true"></i>&nbsp;&nbsp;Kamar
                                    Mandi
                                </p>
                                @endif
                                @if(str_contains($kamar->facilities,'Ac'))
                                <p><i class="fa fa-retweet" aria-hidden="true"></i>&nbsp;&nbsp;Air
                                    Conditioner</p>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <p class="mt-3">Rp.{{$kamar->price}},00</p>
                            </div>
                            <div class="col-md-2">
                                @if($kamar->status == 'available')
                                <?php $available++; ?>
                                <input class="mt-3" type="checkbox" value="{{$kamar->id}}"
                                       name="checkbox[]" >
                                @else
                                <p class="mt-3">Booked</p>
                                @endif
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        <div align="end">
                            @if($available > 0)
                            <button type="submit" onclick="submits()" class="btn essence-btn-sm">Pesan
                                Homestay
                            </button>
                            @else
                            <button type="submit" disabled onclick="submits()" class="btn essence-btn-sm">Pesan
                                Homestay
                            </button>
                            @endif
                        </div>

                        <br>
                    </div>
                </form>
            </div>
            <div class="col-md-2">

            </div>
            <br>
        </div>

        @if(count($homestays['kamar'])==0)
        <center>
            <img src="/images/assets/search_result_empty.png"
                 style="height: 120px; border: none; opacity: 0.5"/>
            <br>
            <p>Kamar tidak ditemukan</p>
        </center>
        @endif
        <?php $count = 0; ?>
        @foreach ($homestays['kamar'] as $kamar)
        <div class="container card bayangan-luar mt-5" style="background-color: #f2eded">
            <?php $count++ ?>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mt-3">Kamar {{$count}}</h4>
                </div>
                <div class="col-md-5" align="end">
                    <h4 class="mt-3" style="color: darkorange">{{$kamar->kategori}}</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-5">
                    <div class="col-12 mb-3">
                        <img class="img-thumbnail bayangan"
                             src="data:image/jpeg;base64,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"
                             width="1000">
                    </div>
                </div>
                <div class="col-lg-7 bg-white pt-3 pl-3 mb-3 img-thumbnail bayangan">
                    <div class="row">
                        <div class="col-md-12 row">
                            <form class="row pl-3 pr-3" method="POST"
                                  action="{{ url('/homestay/pesan', $kamar->id)}}">
                                {{ csrf_field() }}
                                <div class="col-lg-6">
                                    <p style="margin-bottom: -5px; font-weight: bolder">Check in</p>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"
                                                                             aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input type="date" name="checkIn" class="form-control"
                                               id="inlineFormInputGroup">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p style="margin-bottom: -5px; font-weight: bolder">Durasi</p>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-moon-o"
                                                                             aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input type="number" min="1" class="form-control"
                                               name="durasi" id="inlineFormInputGroup">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p style="margin-bottom: -5px; font-weight: bolder">Tamu</p>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-users"
                                                                             aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input type="number" min="1" name="totalRoom"
                                               class="form-control" id="inlineFormInputGroup">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <p>Fasilitas</p>
                            <hr>
                            @if(str_contains($kamar->facilities,'Wifi'))
                            <p><i class="fa fa-wifi" aria-hidden="true"></i>&nbsp;&nbsp;Wifi</p>
                            @endif
                            @if(str_contains($kamar->facilities,'Pemanas'))
                            <p><i class="fa fa-coffee" aria-hidden="true"></i>&nbsp;&nbsp;Pemanas
                            </p>
                            @endif
                            @if(str_contains($kamar->facilities,'Kamar mandi'))
                            <p><i class="fa fa-bath" aria-hidden="true"></i>&nbsp;&nbsp;Kamar Mandi
                            </p>
                            @endif
                            @if(str_contains($kamar->facilities,'Ac'))
                            <p><i class="fa fa-retweet" aria-hidden="true"></i>&nbsp;&nbsp;Air
                                Conditioner</p>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="col-lg-12 mt-4 mb-3" align="end">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="product-price" style="color: darkorange">Rp {{
                                            number_format("$kamar->price" ,0) }}</h4>
                                        <p style="color: darkorange; margin-top: -10px">
                                            Harga/Kamar/Malam</p>
                                    </div>
                                </div>
                                @if(!$kamar->status == 'available')
                                <button disabled type="submit" class="btn essence-btn-sm">Pesan
                                    Homestay
                                </button>
                                @else
                                <button type="submit" class="btn essence-btn-sm">Pesan
                                    Homestay
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        @endforeach

    </div>
    <hr>
</section>
@endsection
<script>
    function submits() {
        var checked = $("input[type=checkbox]:checked").length;
        if(!checked) {
            alert("You must check at least one checkbox.");
            return false;
        }
    }
</script>
<script>
    import FormPesanHomestay from "../../../js/components/homestay/FormPesanHomestay";

    export default {
        components: {FormPesanHomestay}
    }
</script>
@section('style')
<style>
    .bayangan {
        -webkit-box-shadow: 2px 1px 12px 1px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 2px 1px 12px 1px rgba(0, 0, 0, 0.75);
        box-shadow: 2px 1px 12px 1px rgba(0, 0, 0, 0.75);
    }

    .bayangan-bawah {
        -webkit-box-shadow: 2px 6px 12px -3px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 2px 6px 12px -3px rgba(0, 0, 0, 0.75);
        box-shadow: 2px 6px 12px -3px rgba(0, 0, 0, 0.75);
    }

    /*.bayangan-luar{*/
    /*    -webkit-box-shadow: 0px 2px 35px -17px rgba(0,0,0,0.75);*/
    /*    -moz-box-shadow: 0px 2px 35px -17px rgba(0,0,0,0.75);*/
    /*    box-shadow: 0px 2px 35px -17px rgba(0,0,0,0.75);*/
    /*}*/
</style>
@endsection
