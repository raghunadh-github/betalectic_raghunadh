@extends('layouts.app')
@section('title')
    {{$title}}
@endsection
@section('content')
@if ( !$blogs->count() )
    There is no blog till now. Login and write a new blog now!!!
@else

<div class="container">
  @if (Session::get('error'))
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
      <h4>All Blogs</h4>
    </div> 
  @foreach( $blogs as $blog )
  <div class="list-group">
    <div class="list-group-item">
      <h3><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a> 
        
        @if(!Auth::guest() && ($blog->author_id == Auth::user()->id))          
          <button class="btn" style="float: right"><a href="{{ route('blog.edit', $blog->id) }}">Edit blog</a></button>
        @endif
      </h3>
      <span>{{ $blog->slug }}</span>
      <p>{{ $blog->created_at->format('M d,Y \a\t h:i a') }} By {{ $blog->author->name }}</p>
    </div>
    <div class="list-group-item">
      <article>
        {!! Str::limit($blog->content, $limit = 1500, $end = '....... <a href='.route('blog.show', $blog->slug).'>Read More</a>') !!}
      </article>
    </div>
  </div>
  @endforeach
</div>
@endif
@endsection