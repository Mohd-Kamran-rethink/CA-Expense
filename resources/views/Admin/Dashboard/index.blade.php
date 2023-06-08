@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                    <h5>* if super manager is logged in show them all expense as discuseed yeterday</h5>
                    <h5>* if other user is looged show them their salary with the total number of days they were active means</h5>
                    <h5>* if he took money in advance show subtract the salary accordingly </h5>
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

@endsection
