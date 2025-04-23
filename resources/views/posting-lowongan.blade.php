<x-app-layout>
@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #7b8ac4;
            margin: 0;
            padding: 2rem;
        }
        .form-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 2rem;
            max-width: 700px;
            margin: auto;
        }
        h2 {
            color: white;
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 0.95rem;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .row {
            display: flex;
            gap: 1rem;
        }
        .row .column {
            flex: 1;
        }
        .submit-btn {
            margin-top: 2rem;
            padding: 0.7rem 1.5rem;
            background-color: #4a5fa0;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #3c4d89;
        }
    </style>
@endpush
<body>

    <h2>Posting Lowongan</h2>

    <div class="form-container">
        <form method="POST" action="#">
            @csrf

            <label for="title">Job title</label>
            <input type="text" id="title" name="title" placeholder="Contoh: Backend Developer">

            <label for="description">Job description</label>
            <textarea id="description" name="description" placeholder="Tulis deskripsi pekerjaan di sini..."></textarea>

            <label for="requirement">Requirement</label>
            <textarea id="requirement" name="requirement" placeholder="Tulis kualifikasi atau syarat pelamar..."></textarea>

            <div class="row">
                <div class="column">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Contoh: Yogyakarta">
                </div>
                <div class="column">
                    <label for="experience">Experience</label>
                    <input type="text" id="experience" name="experience" placeholder="Contoh: 1-2 tahun">
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <label for="salary">Salary</label>
                    <input type="text" id="salary" name="salary" placeholder="Contoh: Rp 5.000.000">
                </div>
                <div class="column">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="Contoh: Laravel, Remote, Full-time">
                </div>
            </div>

            <button type="submit" class="submit-btn">Post Job</button>
        </form>
    </div>
</body>
</x-app-layout>
    