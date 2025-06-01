@csrf
<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
        <input type="text" name="title" placeholder="Title" value="{{ old('title', $promotion->title ?? '') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
        <textarea name="description" placeholder="Description" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">{{ old('description', $promotion->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Type</label>
        <select name="type" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            <option value="fixed" {{ old('type', $promotion->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed (RM)</option>
            <option value="percent" {{ old('type', $promotion->type ?? '') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Value</label>
        <input type="number" name="value" step="0.01" placeholder="Value" value="{{ old('value', $promotion->value ?? '') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', isset($promotion) ? $promotion->start_date->toDateString() : '') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date', isset($promotion) ? $promotion->end_date->toDateString() : '') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="auto_apply" value="1" {{ old('auto_apply', $promotion->auto_apply ?? false) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600">
        <label class="text-sm text-gray-700 dark:text-gray-300">Auto Apply</label>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Optional Code</label>
        <input type="text" name="code" placeholder="Enter code if needed" value="{{ old('code', $promotion->code ?? '') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Promo Image</label>
        <input type="file" name="promo_image" accept="image/*" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
    </div>

    @if(isset($promotion) && $promotion->promo_image)
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Current Image Preview:</p>
            <img src="{{ asset('storage/' . $promotion->promo_image) }}" class="w-full max-w-md rounded-lg shadow">
        </div>
    @endif
</div>
