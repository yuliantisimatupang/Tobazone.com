@extends('admin.layouts.app')
@section('title') {{ "Koperasi Aktif" }}
@endsection

@section('content')
<style type="text/css">
    body {
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
    }

    /* Table */
    table {
        margin: auto;
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
        font-size: 12px;

    }

    .demo-table {
        border-collapse: collapse;
        font-size: 13px;
    }

    .demo-table th,
    .demo-table td {
        border-bottom: 1px solid #e1edff;
        border-left: 1px solid #e1edff;
        padding: 7px 17px;
    }

    .demo-table th,
    .demo-table td:last-child {
        border-right: 1px solid #e1edff;
    }

    .demo-table td:first-child {
        border-top: 1px solid #e1edff;
    }

    .demo-table td:last-child {
        border-bottom: 0;
    }

    caption {
        caption-side: top;
        margin-bottom: 10px;
    }

    /* Table Header */
    .demo-table thead th {
        background-color: #508abb;
        color: #FFFFFF;
        border-color: #6ea1cc !important;
        text-transform: uppercase;
    }

    /* Table Body */
    .demo-table tbody td {
        color: #353535;
    }

    .demo-table tbody tr:nth-child(odd) td {
        background-color: #f4fbff;
    }

    .demo-table tbody tr:hover th,
    .demo-table tbody tr:hover td {
        background-color: #a2ffff;
        border-color: #0ff7ff;
        transition: all .2s;
    }
</style>
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="app">
                    <div class="card-header">
                        <strong class="card-title">Layanan Maintenence</strong>
                    </div>
                    <layanan-maintenence></layanan-maintenence>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
