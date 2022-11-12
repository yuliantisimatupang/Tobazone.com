@extends('users.layouts.app')
@section('title') {{ "Homestays" }}
@endsection

@section('content')
<br><br><br>
<div class="container">
    <div class="row justify-content-md-center">
        <div class=" col-md-1">
        </div>
        <div class="col-md-10">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($carousel as $index => $carousel)
                    <div class="carousel-item {{($index==0)?'active':null}}">
                        <img class="d-block w-100" src="{{ '../images/'. $carousel->image}}" alt="First slide">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class=" col-md-1">

        </div>
    </div>

</div>
<section class="shop_grid_area section-padding-80">
    <div class="row">
        <div class="col-md-12">
            <div>
                <div class="card" style="background-color: #FFFAF4" style="outline: none">
                    <div>
                        <form action="/homestays/search" method="POST">
                            {{ csrf_field() }}
                            <div class="container">

                                <br><br>
                                <div class="row justify-content-md-center">
                                    <div class="col col-md-1">

                                    </div>
                                    <div class="col-md-6">

                                        <p style="margin-bottom: -5px; font-weight: bolder">Destinasi Penginapan</p>

                                        <div id="lokasi" class="input-container">
                                            <i class="fa fa-map-marker icon fa-lg" style="color:#000000;"></i>
                                            <input class="form-control" type="text" placeholder="Lokasi" name="kecamatan">
                                        </div>

                                        <div class="row" id="check">
                                            <div class="col-lg-6">
                                                <p style="margin-bottom: -5px; font-weight: bolder">Check in</p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                                    </div>
                                                    <input type="date" class="form-control" id="inlineFormInputGroup">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <p style="margin-bottom: -5px; font-weight: bolder">Durasi</p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fa fa-moon-o" aria-hidden="true"></i></div>
                                                    </div>
                                                    <input type="number" class="form-control" id="inlineFormInputGroup">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-5">
                                                <p style="margin-bottom: -5px; font-weight: bolder">Check out</p>
                                                <p style="margin-bottom: -5px;font-weight: bold;font-weight: bolder">
                                                    Sabtu,26 Dec 2020</p>

                                            </div>
                                        </div>
                                        <label for="tamu">Tamu dan Kamar</label>
                                        <div id="tamu" class="input-container ">
                                            <i class="fa fa-users icon fa-lg" style="color:#000000;"></i>
                                            <input class="form-control" type="number" min="1" name="tamu">
                                        </div>
                                        <br>
                                        <div>

                                            <button class="form-control" style="background-color:#000000; color:#ffffff;" type="submit">Cari
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col col-md-1">

                                    </div>
                                </div>

                                <br><br>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-1">

            </div>
            <div class="col-md-10">
                <!--                <div class="container card products mt-5" style="background-color: #F5F5F5">-->
                <!--                    <div class="row" id="check">-->
                <!--                        <div class="col-lg-6 mt-2 mb-2">-->
                <!--                            <div class="input-group">-->
                <!--                                <div class="text-black-50">-->
                <!--                                    <h3>Menampilkan hasil homestay di </h3>-->
                <!--                                </div>-->
                <!--                                <input type="form-control" placeholder="Laguboti"-->
                <!--                                       style="margin-left: 10px; width: 50px;font-weight: bold;" readonly-->
                <!--                                       class="form-control" id="inlineFormInputGroup">-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="col-lg- mt-2 mb-2">-->
                <!--                            <div class="input-group">-->
                <!--                                <div class="text-black-50">-->
                <!--                                    <h3>Pada tanggal </h3>-->
                <!--                                </div>-->
                <!--                                <input type="form-control" placeholder="25 Desember 2020"-->
                <!--                                       style="margin-left: 10px; font-weight: bold;" readonly class="form-control"-->
                <!--                                       id="inlineFormInputGroup">-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="col-md-1">

            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" onchange="search_kabupaten()" id="kabupaten">
                        <option selected="selected">Cari berdasarkan Kabupaten</option>
                        @foreach ($kabupaten as $val)
                        <option value="{{ $val->kabupaten }}">{{ $val->kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-8"></div>
        </div>
        <div>
            <homestay-terlaris/>
        </div>

        <div class="row justify-content-center">
            <div class="col-auto">
                <div class="card" style="background-color: #F5F5F5">
                    <a href="{{ url('/user/homestayall')}}" class="btn btn-primary" style="background-color:#000000; color:#ffffff;">Muat Lebih Banyak</a>
                </div>
            </div>
        </div>

    </div>


    <!-- Pagination -->
    {{--
    <nav aria-label="navigation">--}}
    {{--
        <ul class="pagination mt-50 mb-70">--}}
    {{--
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#">21</a></li>
            --}}
    {{--
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
            --}}
    {{--
        </ul>
        --}}
    {{--
    </nav>
    --}}
    </div>
    </div>
    </div>
</section>
<!-- ##### Shop Grid Area End ##### -->
@endsection

<style scoped>
    /* Style the input container */
    .input-container {
        display: flex;
        width: 100%;
        margin-bottom: 15px;
    }

    /* Style the form icons */
    .icon {
        padding: 10px;
        background: #F5F5F5;
        color: white;
        min-width: 50px;
        text-align: center;
    }
</style>
<script>
    import HomestayTerlaris from "../../../js/components/homestay/HomestayTerlaris";
    export default {
        components: {HomestayTerlaris}
    }
</script>
