@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Heading -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center justify-center gap-2">
            <x-heroicon-o-user-circle class="w-7 h-7 text-blue-600" />
            Edit Profile
        </h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Update your personal details and profile picture.</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 md:p-10">
        <!-- Avatar Preview -->
        <div class="flex items-center space-x-4 mb-8">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128' }}"
                 alt="User Avatar"
                 class="w-20 h-20 rounded-full border-4 border-blue-500 shadow-md object-cover" id="avatarPreview">
            <div>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $user->name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avatar Upload -->
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1">
                    <x-heroicon-o-camera class="w-5 h-5 text-gray-500" />
                    Change Profile Picture
                </label>
                <input type="file" id="avatar" name="avatar" accept="image/*"
                       class="mt-1 w-full text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white border rounded-md"
                       onchange="previewImage(event)">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Supported: JPG, PNG (max 2MB)</p>
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    <x-heroicon-o-identification class="w-5 h-5 inline-block mr-1 text-gray-500" />
                    Full Name
                </label>
                <input type="text" id="name" name="name"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    <x-heroicon-o-envelope class="w-5 h-5 inline-block mr-1 text-gray-500" />
                    Email Address
                </label>
                <input type="email" id="email" name="email"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    <x-heroicon-o-phone class="w-5 h-5 inline-block mr-1 text-gray-500" />
                    Phone Number
                </label>
                <input type="text" id="phone" name="phone"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('phone', $user->phone) }}">
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200 flex items-center gap-2 justify-center">
                    <x-heroicon-o-arrow-up-tray class="w-5 h-5" />
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('avatarPreview').src = reader.result;
        };
        if(input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
