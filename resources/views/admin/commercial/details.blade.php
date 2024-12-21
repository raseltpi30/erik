@extends('layouts.admin')
@section('title')
Customer
@endsection
@section('admin_content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card m-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$item->first_name}} Details Here</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-right">Name :</th>
                                    <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Email :</th>
                                    <td>{{$item->email}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Phone :</th>
                                    <td>{{$item->phone}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Address :</th>
                                    <td>{{ $item->street . ',' . $item->unit . ',' . $item->city }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Postal Code :</th>
                                    <td>{{ $item->postal_code}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Square Footage :</th>
                                    <td>{{ $item->square_footage}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Floors Number :</th>
                                    <td>{{ $item->number_floors}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Area Type :</th>
                                    <td>{{ $item->types_areas}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Specific Tasks :</th>
                                    <td>{{ $item->specific_tasks}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Cleaning Frequency :</th>
                                    <td>{{ $item->cleaning_frequency}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Cleaning Schedule :</th>
                                    <td>{{ $item->cleaning_schedule}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Access Security :</th>
                                    <td>{{ $item->access_security}}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Additional Services :</th>
                                    <td>{{ $item->additional_services}}</td>
                                </tr>
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
