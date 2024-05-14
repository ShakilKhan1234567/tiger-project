@extends('layouts.admin')
@section('content')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Tag List</h3>
                    </div>
                    @if (session('tag_delete'))
                        <div class="alert alert-success">{{session('tag_delete')}}</div>
                    @endif
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Tag Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($tags as $sl=>$tag)
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>{{$tag->tag_name}}</td>
                                <td>
                                    <a href="{{route('tag.delete', $tag->id)}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Tag</h3>
                    </div>
                    @if (session('tag'))
                        <div class="alert alert-success">{{session('tag')}}</div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('tag.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tag Name</label>
                             <input type="text" name="tag_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Add Tag</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
