@extends('admin.layouts.app')
@section('title') {{ "Detail Orders" }}
@endsection

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Detail Order</strong>
                        </div>
                        <div class="card-body">
                        <!-- <div class="typo-headers">
                            <h3 class="pb-2 display-5"># {{ $transaction->id}}</h3>
                        </div> -->
                            <div class="typo-articles">
                                <blockquote class="blockquote mt-3 text-left">
                                    <p> {{ $transaction->created_at }} </p>
                                    <footer class="blockquote-footer"><b> {{ $transaction->customer->profile->name}}</b>
                                    </footer>
                                </blockquote>
                            </div>

                            <div class="vue-lists">
                                <h4 class="mb-4">Product List</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Harga</th>
                                                <!-- <th scope="col">Diskon (%)</th> -->
                                                <th scope="col">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $jumlah_total = 0; ?>
                                            @foreach ($transaction->orders as $idx => $order)
                                                <tr>
                                                    <th scope="row"> {{$idx + 1}}</th>
                                                    <td>{{ $order->product->name }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>IDR {{ number_format($order->price) }}</td>
                                                    <!-- <td>0%</td> -->
                                                    <td>IDR {{ number_format($order->price * $order->quantity) }}</td>
                                                    <?php $jumlah_total = $jumlah_total + ($order->product->price * $order->quantity) ?>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="vue-misc">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="mb-4">Detail Pengembalian</h3>
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <th>Total Harga Produk</th>
                                                <td>IDR {{ number_format($transaction->payment->product_cost) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Pengiriman</th>
                                                <td>IDR {{ number_format($transaction->payment->shipping_cost) }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total yang Harus Dikembalikan</th>
                                                <td>
                                                    <b>IDR {{ number_format($transaction->payment->product_cost + $transaction->payment->shipping_cost) }}</b>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="vue-misc" style="margin-top : 2px">
                                <!-- <h2 class="display-5 my-3">Misc</h2> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Address</h3>
                                        <address class="mt-3">
                                            {{ $transaction->address }}<br>
                                            {{ $transaction->customer->email}}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="mb-3">Proof of Payment</h3>
                                        @if($transaction->payment->proof)
                                            <div class="jumbotron">
                                                <img class="card-img-top"
                                                     src="{{ url('/images/proof-of-payment', json_decode($transaction->payment->proof)->image)}}"
                                                     alt="Resi pembayaran">
                                            </div>
                                        @else
                                            <div class="jumbotron align-center">
                                                <h3 class="text-danger"> Not Paid Yet </h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card-body">
                                <form action="#">
                                    <input type="hidden" name="status" value="readyForProcess" />
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Selesai</button>
                                </form>
                            </div> -->
                        <!--
                        <div class="card-body">
                            <form action="{{ url('/transaction/update-status', $transaction->id)}}" method="POST">
                                {{ csrf_field() }}
                            <input type="hidden" name="status" value="invalidProofOfPayment" />
                            <button type="submit" class="btn btn-danger btn-lg btn-block">Reject</button>
                        </form>
                    </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
