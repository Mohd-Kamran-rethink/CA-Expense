@extends('Admin.index')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Expenses </h1>
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



    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-centers">
                    <form action="{{ url('expenses') }}" method="GET" id="search-form">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" value="{{ isset($searchTerm) ? $searchTerm : '' }}" name="table_search"
                                class="form-control float-right" placeholder="Search" id="searchInput">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default" onclick="searchData()" id="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div>
                        <a href="{{ url('expenses/add') }}" class="btn btn-primary">Add New Expense</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Amount</th>
                                            <th>Department</th>
                                            <th>Expense Type</th>
                                            <th>Transaction Type</th>
                                            <th>Currency</th>
                                            <th>Attatchement</th>
                                            <th>remark</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($expenses as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->departmenName }}</td>
                                                <td>{{ $item->expenseType }}</td>
                                                <td>{{ $item->transaction_type }}</td>
                                                <td style="text-transform: capitalize">{{ $item->currency_type }}</td>
                                                <td>{{ $item->attatchement ? 'Yes' : 'No' }}</td>
                                                <td>{{ $item->remark }}</td>
                                                <td>
                                                    <button title="Delete this expense"
                                                        onclick="manageModal({{ $item->id }})"
                                                        class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    @if ($item->attatchement)
                                                        <a href="{{ url('expenses/download/attatchement/'.$item->id) }}"
                                                            title="Download attatchement" class="btn btn-success"><i
                                                                class="fa fa-download"></i></a>
                                                    @endif
                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No data</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade show" id="modal-default" style=" padding-right: 17px;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete expense</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('/expenses/delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="deleteId" id="deleteInput">

                    <div class="modal-body">
                        <h4>Are you sure you want to delete this expense?</h4>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" data-dismiss="modal" aria-label="Close"
                            class="btn btn-default">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function manageModal(id) {
            $('#modal-default').modal('show')
            $('#deleteInput').val(id)
        }
    </script>
@endsection
