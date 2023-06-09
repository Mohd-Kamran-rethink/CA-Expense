@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($expenses) ? 'Edit Expense Type' : 'Add Expense Type' }}</h1>
                    <h6 class="text-danger">* Items marked with an asterisk are required fields and must be completed</h6>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ isset($expenses) ? url('expenses/edit') : url('expenses/add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="expensesId" value="{{ isset($expenses) ? $expenses->id : '' }}">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Department<span style="color:red">*</span></label>
                                <select onchange="renderExpenseType(this.value)" name="department_id" id=""
                                    class="form-control">
                                    <option value="0">--Choose--</option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" id="expense-type-render">
                                <label>Expense Type<span style="color:red">*</span></label>
                                <select disabled name="expensse_type" id="expense-type" class="form-control">
                                    <option value="0">--Choose--</option>
                                    @foreach ($expenseTypes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Currency<span style="color:red">*</span></label>
                                <select name="currency" id="currency" class="form-control">
                                    <option value="0">--Choose--</option>
                                    <option value="rupee">Rupee</option>
                                    <option value="aed">AED</option>
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
                                <label>Creditor</label>
                                <select name="creditor_id" id="creditor_id" class="form-control">
                                    <option value="0">--Choose--</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error('creditor_id')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Transaction Type<span style="color:red">*</span></label>
                                <select name="transactionType" id="transactionType" class="form-control">
                                    <option value="0">--Choose--</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                                @error('transactionType')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Debiter Bank<span style="color:red">*</span></label>
                                <select name="bank_id" id="bank_id" class="form-control">
                                    <option value="0">--Choose--</option>
                                        @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->account_number.' - ('.$item->holder_name    .')'}}</option>
                                    @endforeach
                                </select>
                                        
                                @error('bank_id')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Amount<span style="color:red">*</span></label>
                                <input type="number" name="amount" class="form-control" data-validation="required"
                                    value="{{ isset($expenses) ? $expenses->amount : old('amount') }}">
                                @error('amount')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label>Attatchement</label>
                                <input type="file" name="attatchement" class="form-control" data-validation="required"
                                    value="{{ isset($expenses) ? $expenses->amount : old('amount') }}">
                                @error('attatchement')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Remark</label>   
                                <textarea name="remark" id="" cols="1" rows="" class="form-control"></textarea>
                                @error('remark')
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
                            <a href="{{ url('/expense-type') }}" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function renderExpenseType(id) {
            let expenseTypeInput = $('#expense-type')
            if (id == 0) {
                expenseTypeInput.attr('disabled', true);
            } else {
                $.ajax({
                    url: BASE_URL +
                        "/expenses/render-expense-type?department=" + id,
                    success: function(data) {
                        expenseTypeInput.removeAttr('disabled');
                        $("#expense-type-render").html(data);

                    },
                });
            }

        }
    </script>
@endsection
