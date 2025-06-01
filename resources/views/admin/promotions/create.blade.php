@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    @include('components.admin.sidebar')

    <main class="flex-1 p-6 lg:p-10 space-y-8 container mx-auto max-w-3xl">
        <!-- Page Header -->
        <div class="flex items-center gap-3">
            <x-heroicon-o-megaphone class="w-6 h-6 text-blue-600 dark:text-blue-400" />
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Create Promotion</h2>
        </div>

        <!-- Promotion Form -->
        <form method="POST" action="{{ route('promotions.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md space-y-6">
            @csrf

            <div class="grid gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium mb-1">Title</label>
                    <div class="relative">
                        <x-heroicon-o-pencil-square class="w-5 h-5 absolute top-2.5 left-3 text-gray-400" />
                        <input type="text" id="title" name="title" placeholder="Title" required
                            value="{{ old('title', $promotion->title ?? '') }}"
                            class="pl-10 input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white" />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium mb-1">Description</label>
                    <textarea id="description" name="description" placeholder="Description"
                        class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white">{{ old('description', $promotion->description ?? '') }}</textarea>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium mb-1">Promotion Type</label>
                    <select name="type" id="type" required
                        class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white">
                        <option value="fixed" {{ old('type', $promotion->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed (RM)</option>
                        <option value="percent" {{ old('type', $promotion->type ?? '') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                    </select>
                </div>

                <!-- Value -->
                <div>
                    <label for="value" class="block text-sm font-medium mb-1">Value</label>
                    <input type="number" id="value" name="value" step="0.01" required
                        value="{{ old('value', $promotion->value ?? '') }}"
                        class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white" />
                </div>

                <!-- Date Range -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required
                            value="{{ old('start_date', isset($promotion) ? $promotion->start_date->toDateString() : '') }}"
                            class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white" />
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end_date" name="end_date" required
                            value="{{ old('end_date', isset($promotion) ? $promotion->end_date->toDateString() : '') }}"
                            class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white" />
                    </div>
                </div>

                <!-- Auto Apply -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="auto_apply" name="auto_apply" value="1"
                        {{ old('auto_apply', $promotion->auto_apply ?? false) ? 'checked' : '' }}
                        class="rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700">
                    <label for="auto_apply" class="text-sm">Auto Apply</label>
                </div>

                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-medium mb-1">Promotion Code (Optional)</label>
                    <input type="text" id="code" name="code"
                        value="{{ old('code', $promotion->code ?? '') }}"
                        class="input w-full rounded-lg border dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500 focus:outline-none text-sm text-gray-900 dark:text-white" />
                </div>

                <!-- Promo Image -->
                <div>
                    <label for="promo_image" class="block text-sm font-medium mb-1">Promotion Image</label>
                    <input type="file" id="promo_image" name="promo_image"
                        class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-xs mb-1">Preview:</p>
                        <img id="preview-img" class="max-h-40 rounded-lg shadow" />
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full inline-flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow">
                    <x-heroicon-o-check-circle class="w-5 h-5" />
                    Save Promotion
                </button>
            </div>
        </form>
    </main>
</div>

<!-- Preview JS -->
@push('scripts')
<script>
    document.getElementById('promo_image').addEventListener('change', function (e) {
        const previewContainer = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const file = e.target.files[0];

        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
