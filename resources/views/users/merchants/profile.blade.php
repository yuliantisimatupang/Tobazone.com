<div class="row">
    <div class="col-12">
        <div class="card globalcard store">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-3 d-none d-sm-block store-image px-0">
                        @if($merchant->profile->photo == NULL)
                            <div class="imgwrapper">
                                <img src="{{ url('/images/assets/no-image.jpg') }}" alt="">
                            </div>
                        @else
                            <div class="imgwrapper">
                                <img src="{{ url("/images/user_profiles/".$merchant->profile->photo )}}" alt="">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9 col-sm-12 store-name pl-0">
                        <div class="row">
                            <div class="col-10 col-sm-8 col-md-10">
                                <h5 class="mb-0"> {{ $merchant->profile->name }}</h5>
                            </div>

                            <div class="col-2 ">
                                <a href="{{ url('/merchant/'.$merchant->id.'/editProfile') }}">
                                    <button type="submit" class="button essence-btn btn-sm float-right">
                                        <i class="fa fa-gear"></i> &nbsp; UBAH
                                    </button>
                                </a>
                            </div>
                        </div>
                        <p> Horas Mamangke Mangomo Partiga-tiga </p>
                        <div class="store-desc">
                            <i class="fa fa-map mr-1"></i> {{$merchant->profile->address->subdistrict_name}} {{", " . $merchant->profile->address->city_name}}
                            {{", " . $merchant->profile->address->province_name}} <br>
                            <i class="fa fa-clock-o mr-1"></i>{{date('d-m-Y', strtotime($merchant->email_verified_at))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
