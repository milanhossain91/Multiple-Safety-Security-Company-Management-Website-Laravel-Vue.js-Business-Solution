@extends('admin.layout')
@section('title', 'New Page')
@section('page_title', 'Create Page')
@section('page_subtitle', 'Compose a new page using content blocks')

@section('admin_content')
    @include('admin.pages._form', ['action' => url('/admin/pages')])
@endsection
