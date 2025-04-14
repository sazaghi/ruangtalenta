<x-app-layout>
    <div class="max-w-6xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-6">Buat Test untuk Pekerjaan</h2>

        <!-- Pilih Job untuk Test -->
        <form action="{{ route('test.store') }}" method="POST">
            @csrf

            <label for="job">Pilih Pekerjaan:</label>
            <select name="job_id" id="job" class="w-full border rounded p-2 mb-2">
                @foreach ($jobs as $job)  {{-- Pastikan $jobs dikirim ke view --}}
                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                @endforeach
            </select>

            <label for="question">Pertanyaan:</label>
            <textarea name="question" id="question" class="w-full border rounded p-2 mb-2"></textarea>

            <label for="option_a">Opsi A:</label>
            <input type="text" name="option_a" id="option_a" class="w-full border rounded p-2 mb-2">

            <label for="option_b">Opsi B:</label>
            <input type="text" name="option_b" id="option_b" class="w-full border rounded p-2 mb-2">

            <label for="option_c">Opsi C:</label>
            <input type="text" name="option_c" id="option_c" class="w-full border rounded p-2 mb-2">

            <label for="option_d">Opsi D:</label>
            <input type="text" name="option_d" id="option_d" class="w-full border rounded p-2 mb-2">

            <label for="correct_answer">Jawaban Benar:</label>
            <select name="correct_answer" id="correct_answer" class="w-full border rounded p-2 mb-4">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <div class="flex justify-between mt-4">
                <a href="{{ route('job.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
