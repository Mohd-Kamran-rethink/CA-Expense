@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($departments) ? 'Edit Expense Type' : 'Add Expense Type' }}</h1>
                    <h6 class="text-danger">* Items marked with an asterisk are required fields and must be completed</h6>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ isset($departments) ? url('departments/edit') : url('departments/add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="departmentsId" value="{{ isset($departments) ? $departments->id : '' }}">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Department Name<span style="color:red">*</span></label>
                                <input type="text" name="name" class="form-control" data-validation="required"
                                    value="{{ isset($departments) ? $departments->name : old('name') }}">
                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Assign To<span style="color:red">*</span></label>
                                <select name="user_id" id="" class="form-control">
                                    <option value="0">--Choose--</option>
                                    @foreach ($managers as $item)
                                        @if($item->id==1||$item->id==2)
                                            @continue
                                        @endif
                                        <option value="{{$item->id}}" style="text-transform: capitalize">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                    
                                @error('user_id')
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
                            <a href="{{ url('/departments') }}" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
