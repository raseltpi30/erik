@extends('layouts.admin')
@section('title')
Stripe Subscrber 
@endsection
@section('admin_content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card m-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="button-new" style="display: flex;justify-content:space-between;align-items:center">
                            <h4 class="card-title">All Subscriber List Here</h4>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Status</th>
                                        <th>Frequency</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionsWithCustomers as $key => $subscription)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $subscription->customer_name }}</td>
                                        <td>{{ $subscription->customer_email }}</td>
                                        <td>
                                            @if ($subscription->status == 'active')
                                            <div class="badge bg-success">
                                                {{ ucfirst($subscription->status) }}
                                            </div>
                                            @else
                                            <div class="badge bg-danger">
                                                {{ ucfirst($subscription->status) }}
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ ucfirst($subscription->frequency) }} ({{ $subscription->interval_count }}
                                            {{ $subscription->interval }})
                                        </td>
                                        <td>${{ $subscription->amount }} AUD</td>
                                        <td>
                                            <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                            </form>
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
