@extends('layouts.app')
@section('title')
    Edit Post
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
        <h4>Edit Blog</h4>
      </div>
    <form method="post" action='{{ route('blog.update') }}'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $blog->id }}{{ old('id') }}">
        <div class="form-group">
            <input required="required" value="@if(!old('title')){{$blog->title}}@endif{{ old('title') }}" placeholder="Enter title here" type="text" name = "title" class="form-control"/>
        </div>
        <div class="form-group">
            <input required="required" value="@if(!old('slug')){{$blog->slug}}@endif{{ old('slug') }}" placeholder="Enter Slug here" type="text" name = "slug" class="form-control" />
        </div>
        <div class="form-group">
            <textarea name='content'class="form-control">@if(!old('content')){{ $blog->content }}@endif{{ old('content') }}</textarea>
        </div>
        <input type="submit" name='publish' class="btn btn-success" value = "Update"/>     
        <a href="{{  route('blog.delete', $blog->id) }}" class="btn btn-danger">Delete</a>
    </form>
</div>
@endsection