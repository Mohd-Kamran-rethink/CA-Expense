@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($pettycash) ? 'Edit Petty Cash' : 'Add Petty Cash' }}</h1>
                    <h6 class="text-danger">* Items marked with an asterisk are required fields and must be completed</h6>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ isset($pettycash) ? url('pettycash/edit') : url('pettycash/add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="pettycashId" value="{{ isset($pettycash) ? $pettycash->id : '' }}">
                        
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Petty Type<span style="color:red">*</span></label>
                                <select name="petty_type" id="" class="form-control">
                                    <option value="0">--Choose--</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                                @error('petty_type')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Currency<span style="color:red">*</span></label>
                                <select name="currency" id="" class="form-control">
                                    <option value="0">--Choose--</option>
                                    <option value="aed">AED</option>
                                    <option value="inr">INR</option>
                                    <option value="usd">USD</option>
                                </select>
                                @error('currency')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Amount<span style="color:red">*</span></label>
                                <input type="text" name="amount" class="form-control" data-validation="required"
                                    value="{{ isset($pettycash) ? $pettycash->name : old('amount') }}">
                                @error('amount')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Currency Rate<span style="color:red">*</span></label>
                                <input type="number" step="any" name="currency_rate" class="form-control">
                                @error('currency_rate')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-info">Save</button>
                            <a href="{{ url('/pettycash') }}" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
