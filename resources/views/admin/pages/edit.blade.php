@extends('admin.layout')
@section('title', 'Edit Page')
@section('page_title', 'Edit Page')
@section('page_subtitle', $page->title)
@section('page_actions')
    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-light"><i class="fas fa-eye mr-1"></i> View</a>
@endsection

@section('admin_content')
    @include('admin.pages._form', ['action' => url('/admin/pages/' . $page->id)])
@endsection
