@extends('admin.layouts.app') 
@section('title') {{ "Permissions" }}
@endsection
 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="orders">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pull-left">
                                    <h3 class="box-title"> Permissions </h3>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPermissionModal"> Add Permission </button>
                                </div>
                            </div>
                            
                            @include('admin.permissions.modal')

                            <div class="card-body--">
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th class="serial">#</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $idx => $permission)
                                            <tr>
                                                <td class="serial"> {{ $idx+1 }}</td>
                                                <td> <span class="name"> {{ $permission->name}}</span> </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPermissionModal" onclick="editPermission({{$permission}})"> Edit </button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePermissionModal"> Delete </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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