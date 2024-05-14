@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Faq Single View</h3>
                <a href="{{route('faq.index')}}" class="btn btn-primary">Faq List</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Question</td>
                        <td>{{$show->question}}</td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td>{{$show->answer}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
