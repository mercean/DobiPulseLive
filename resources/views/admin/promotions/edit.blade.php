@extends('layouts.master')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-xl font-bold mb-4">✏️ Edit Promotion</h2>

<form method="POST" action="{{ route('promotions.update', $promotion) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.promotions._form')
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Update</button>
</form>


</div>
@endsection

