@extends('layouts.app')
@section('title')
Add New Post
@endsection
@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (Session::get('success'))
    <div class="alert alert-succes">
            {{ Session::get('success') }}
    </div>
    @endif
    <div class="page-header">
        <h4>New Blog</h4>
      </div>
    <form action="{{ route('blog.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />
        </div>
        <div class="form-group">
            <input required="required" value="{{ old('slug') }}" placeholder="Enter Slug here" type="text" name = "slug" class="form-control" />
        </div>
        <div class="form-group">
            <textarea name='content'class="form-control">{{ old('content') }}</textarea>
        </div>
        <input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
    </form>
</div>
@endsection