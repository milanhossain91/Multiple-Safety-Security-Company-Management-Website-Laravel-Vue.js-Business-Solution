@extends('admin.layout')
@section('title', 'Site Settings')
@section('page_title', 'Site Settings')
@section('page_subtitle', 'Global settings used across the website (logo, contact, social, SEO)')

@php
    $groupLabels = [
        'general' => ['Branding / General', 'fa-sliders'],
        'header'  => ['Header', 'fa-window-maximize'],
        'footer'  => ['Footer', 'fa-window-minimize'],
        'contact' => ['Contact Information', 'fa-address-book'],
        'social'  => ['Social Links', 'fa-share-nodes'],
        'seo'     => ['SEO Defaults', 'fa-magnifying-glass'],
    ];
    $prettify = fn ($key) => ucwords(str_replace('_', ' ', $key));
@endphp

@section('admin_content')
@if ($settings->isEmpty())
    <div class="card"><div class="card-body text-center py-5 text-muted">
        <i class="fas fa-gear fa-3x text-gray-300 mb-3"></i>
        <p>No settings found. Run the demo seeder to populate default settings.</p>
    </div></div>
@else
<form action="{{ url('/admin/settings') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        @foreach ($settings as $group => $items)
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas {{ $groupLabels[$group][1] ?? 'fa-gear' }} mr-1"></i>
                        {{ $groupLabels[$group][0] ?? ucfirst($group) }}
                    </div>
                    <div class="card-body">
                        @foreach ($items as $setting)
                            <div class="form-group">
                                <label class="font-weight-bold small">{{ $prettify($setting->key) }}</label>

                                @switch($setting->type)
                                    @case('textarea')
                                        <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="2">{{ $setting->value }}</textarea>
                                        @break

                                    @case('boolean')
                                        <select name="settings[{{ $setting->key }}]" class="form-control">
                                            <option value="1" {{ $setting->value ? 'selected' : '' }}>Enabled</option>
                                            <option value="0" {{ $setting->value ? '' : 'selected' }}>Disabled</option>
                                        </select>
                                        @break

                                    @case('image')
                                        @if ($setting->value)
                                            <div class="mb-2"><img src="{{ asset($setting->value) }}" alt="{{ $setting->key }}" style="max-height:60px" class="rounded border"></div>
                                        @endif
                                        <input type="file" name="uploads[{{ $setting->key }}]" class="form-control-file">
                                        <input type="hidden" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                                        @break

                                    @case('html')
                                        <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="4">{{ $setting->value }}</textarea>
                                        @break

                                    @default
                                        <input type="text" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-floppy-disk mr-1"></i> Save All Settings</button>
</form>
@endif
@endsection
