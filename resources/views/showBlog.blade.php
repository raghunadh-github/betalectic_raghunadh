@extends('layouts.app')
@section('title')
  Show Blog
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
      <h4>Show Blog</h4>
    </div>
    @if($blog)
     <h4> {{ $blog->title }} </h4>
     <p>{{ $blog->created_at->format('M d,Y \a\t h:i a') }} By {{ $blog->author->name }}</p>
      @if( ($blog->author_id == Auth::user()->id))
        <button class="btn" style="float: right"><a href="{{ route('blog.edit', $blog->id)}}">Edit Post</a></button>
      @endif
      <div>
        {!! $blog->content !!}
    </div> 
    @else
      Page does not exist
    @endif
  @endsection 

</div>