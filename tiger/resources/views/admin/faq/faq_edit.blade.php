@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Faq Edit</h3>
                    <a href="{{route('faq.index')}}" class="btn btn-primary">Faq List</a>
                </div>
                @if (session('update_success'))
                <div class="alert alert-success">{{session('update_success')}}</div>
                @endif
                <div class="card-body">
                    <form action="{{route('faq.update', $faq_edit)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" name="question" class="form-control" value="{{$faq_edit->question}}">
                        </div>
                        @error('question')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea name="answer" class="form-control" cols="30" rows="5">{{$faq_edit->answer}}</textarea>
                        </div>
                        @error('answer')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
