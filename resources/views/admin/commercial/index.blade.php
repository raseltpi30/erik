@extends('layouts.admin')
@section('title')
Commercial
@endsection
@section('admin_content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card m-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="button-new" style="display: flex;justify-content:space-between;align-items:center">
                            <h4 class="card-title">Commercial</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Street</th>
                                        <th>City</th>
                                        <th>Cleaning Frequency</th>
                                        <th>Cleaning Schedule</th>
                                        <th>Access Security</th>
                                        <th>Additional Services</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commercial as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->first_name ?? 'null' }}</td>
                                        <td>{{ $item->last_name ?? 'null' }}</td>
                                        <td>{{ $item->email ?? 'null' }}</td>
                                        <td>{{ $item->phone ?? 'null' }}</td>
                                        <td>{{ $item->street ?? 'null' }}</td>
                                        <td>{{ $item->city ?? 'null' }}</td>
                                        <td>{{ $item->cleaning_frequency ?? 'null' }}</td>
                                        <td>{{ $item->cleaning_schedule ?? 'null' }}</td>
                                        <td>{{ $item->access_security ?? 'null' }}</td>
                                        <td>{{ $item->additional_services ?? 'null' }}</td>
                                        </td>
                                        <td>
                                            <a href="{{ route('commercial.details', $item->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('commercial.delete', $item->id) }}"
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
