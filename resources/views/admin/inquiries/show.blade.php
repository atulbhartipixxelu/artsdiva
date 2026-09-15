@extends('admin.layout')
@section('title','Inquiry Detail')
@section('heading','Inquiry #{{ $item->id }}')
@section('content')
<div class="panel">
<p><strong>Name:</strong> {{ $item->name }}</p>
<p><strong>Email:</strong> {{ $item->email }}</p>
<p><strong>Phone:</strong> {{ $item->phone ?: '—' }}</p>
<p><strong>Artwork:</strong> {{ $item->artwork }}</p>
<p><strong>Lease duration:</strong> {{ $item->lease_duration }}</p>
<p><strong>Budget:</strong> {{ $item->budget_range }}</p>
<p><strong>Message:</strong><br>{{ $item->message ?: '—' }}</p>
<p><strong>Status:</strong> {{ $item->status }}</p>
<p><strong>Submitted:</strong> {{ $item->created_at->format('d M Y H:i') }}</p>
<div class="actions"><a class="btn secondary" href="{{ route('admin.inquiries.index') }}">Back</a></div>
</div>
@endsection
