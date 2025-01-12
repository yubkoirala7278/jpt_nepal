@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Update Account</h2>
    <form action="{{ route('account.update',$account->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="bank_name" class="form-label">Bank Name</label>
            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name"
                value="{{ old('bank_name',$account->bank_name) }}">
            @if ($errors->has('bank_name'))
                <span class="text-danger">{{ $errors->first('bank_name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="account_name" class="form-label">Account Name</label>
            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Account Name"
                value="{{ old('account_name',$account->account_name) }}">
            @if ($errors->has('account_name'))
                <span class="text-danger">{{ $errors->first('account_name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" class="form-control" id="account_number" name="account_number"
                placeholder="Enter Account Number" value="{{ old('account_number',$account->account_number) }}">
            @if ($errors->has('account_number'))
                <span class="text-danger">{{ $errors->first('account_number') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="branch_name" class="form-label">Branch Name</label>
            <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Enter Branch Name"
                value="{{ old('branch_name',$account->branch_name) }}">
            @if ($errors->has('branch_name'))
                <span class="text-danger">{{ $errors->first('branch_name') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="qr_code" class="form-label">Upload Qr Code</label>
            <input type="file" class="form-control" id="qr_code" name="qr_code"
                accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg" />
            @if ($errors->has('qr_code'))
                <span class="text-danger">{{ $errors->first('qr_code') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
