@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Faq List</h3>
                    <a href="{{route('faq.create')}}" class="btn btn-primary">Faq Form</a>
                </div>
                @if (session('delete'))
                <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($faqs as $faq)
                        <tr>
                            <td>{{$faq->question}}</td>
                            <td>{{$faq->answer}}</td>
                            <td class="d-flex">
                                <a href="{{route('faq.show', $faq->id)}}" class="btn btn-info">View</a>
                                <a href="{{route('faq.edit', $faq->id)}}" class="btn btn-primary">Edit</a>
                                <form action="{{route('faq.destroy',$faq->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
