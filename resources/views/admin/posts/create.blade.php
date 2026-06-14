@extends('admin.layout')
@section('title', 'New Post')
@section('page_title', 'New Blog Post')
@section('admin_content')
    @include('admin.posts._form')
@endsection
