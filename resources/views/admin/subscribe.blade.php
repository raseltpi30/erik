@extends('layouts.admin')
@section('title')
    Subscribe
@endsection

@section('admin_content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="button-new" style="display: flex;justify-content:space-between;align-items:center">
                                <h4 class="card-title">All Subscriber Here: </h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscribe as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td><label class="badge badge-success">{{ $item->status }}</label></td>
                                                <td>
                                                    <a href="{{ route('subscribe.delete', $item->id) }}"
                                                        class="btn btn-danger btn-sm" id="delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
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
        <!-- content-wrapper ends -->
    </div>
@endsection
