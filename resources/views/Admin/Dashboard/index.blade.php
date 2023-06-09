@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold">Dashboard</h1>
                </div>
            </div>
            @if (session()->has('msg-success'))
                <div class="alert alert-success" role="alert">
                    {{ session('msg-success') }}
                </div>
            @elseif (session()->has('msg-error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('msg-success') }}
                </div>
            @endif
        </div>
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daily Financial Details</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalDailyExpense ?? 0 }}</h3>
                            <p>Your Today's Expense</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/expenses') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalDailyCredit ?? 0 }}</h3>
                            <p>Your Today's Credits</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/credits') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Monthly Financial Details</h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalMonthlyExpense ?? 0 }}</h3>
                            <p>Monthly Expense</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/expenses') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalMonthlyCredit ?? 0 }}</h3>
                            <p>Your Today's Credits</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/credits') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Total Financial Details</h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalExpense ?? 0 }}</h3>
                            <p>Monthly Expense</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/expenses') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalCredit ?? 0 }}</h3>
                            <p>Your Today's Credits</p>
                        </div>
                        <div class="icon">
                            <i class="fa">₹</i>
                        </div>
                        <a href="{{ url('/credits') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
