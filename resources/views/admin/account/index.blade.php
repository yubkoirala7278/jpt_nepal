@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Accounts</h2>
        <a class="btn btn-secondary btn-sm" href="{{route('account.create')}}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Branch Name</th>
                    <th>Qr Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($accounts)>0)
                    @foreach ($accounts as $key=>$account)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$account->bank_name}}</td>
                        <td>{{$account->account_name}}</td>
                        <td>{{$account->account_number}}</td>
                        <td>{{$account->branch_name}}</td>
                        <td><img src="{{asset($account->qr_code)}}" alt="QR Image" height="30" loading="lazy"></td>
                        <td>
                            <form action="{{ route('account.destroy', $account->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this account?');" class=" d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ">Delete</button>
                            </form>
                            <a href="{{route('account.edit',$account->slug)}}" class="btn btn-warning  d-inline">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr class="text-center">
                    <td colspan="20">No data to display..</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{$accounts->links('pagination::bootstrap-5')}}
    </div>
@endsection



