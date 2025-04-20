<form method="POST" action="{{ route('bio.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
        <label for="full_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="mt-1 block w-full" value="{{ old('full_name') }}">
        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="contact_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number" class="mt-1 block w-full" value="{{ old('contact_number') }}">
        @error('contact_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="website" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Website</label>
        <input type="url" name="website" id="website" class="mt-1 block w-full" value="{{ old('website') }}">
        @error('website') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="bio" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Bio</label>
        <textarea name="bio" id="bio" class="mt-1 block w-full">{{ old('bio') }}</textarea>
        @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="experience" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Experience</label>
        <input type="text" name="experience" id="experience" class="mt-1 block w-full" value="{{ old('experience') }}">
        @error('experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="education_level" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Education Level</label>
        <input type="text" name="education_level" id="education_level" class="mt-1 block w-full" value="{{ old('education_level') }}">
        @error('education_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="facebook" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Facebook</label>
        <input type="text" name="facebook" id="facebook" class="mt-1 block w-full" value="{{ old('facebook') }}">
        @error('facebook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="twitter" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Twitter</label>
        <input type="text" name="twitter" id="twitter" class="mt-1 block w-full" value="{{ old('twitter') }}">
        @error('twitter') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="instagram" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Instagram</label>
        <input type="text" name="instagram" id="instagram" class="mt-1 block w-full" value="{{ old('instagram') }}">
        @error('instagram') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="avatar" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Avatar</label>
        <input type="file" name="avatar" id="avatar" class="mt-1 block w-full">
        @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4">
        <label for="skills" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Skills</label>
        <input type="text" name="skills" id="skills" class="mt-1 block w-full" value="{{ old('skills') }}" placeholder="Contoh: PHP, Laravel, JavaScript">
        @error('skills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>


    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Simpan Bio
        </button>
    </div>
</form>
