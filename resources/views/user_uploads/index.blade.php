<x-app-layout>
{{-- Daftar File dari resume_path dan application_letter_path --}}
<h3 class="text-lg font-bold mb-3">Uploaded File</h3>

@if (count($files))
    <ul class="space-y-3">
        @foreach ($files as $file)
            <li class="border p-4 rounded bg-white shadow-sm flex justify-between items-center">
                <div>
                    <p><strong>{{ $file['type'] }}:</strong></p>
                    <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $file['path'] }}
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-gray-500">no files have been uploaded</p>
@endif

</x-app-layout>