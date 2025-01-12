@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Update Faq's</h2>
    <form action="{{ route('faq.update',$faq->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" id="question" name="question" placeholder="Enter Question"
                value="{{ old('question',$faq->question) }}">
            @if ($errors->has('question'))
                <span class="text-danger">{{ $errors->first('question') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label">Answer</label>
            <textarea class="form-control" placeholder="Write Answer" name="answer">{{old('answer',$faq->answer)}}</textarea>
            @if ($errors->has('answer'))
                <span class="text-danger">{{ $errors->first('answer') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

