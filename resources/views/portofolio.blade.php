<x-app-layout>
    @push('styles')
<style>
    body {
            background-color: #6B7ACB;
            color: #000;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .top-bar {
            padding: 20px;
            color: white;
            font-weight: bold;
        }
        .top-right {
            float: right;
        }
        .btn-upload {
            background-color: #4c6ef5 !important;
            color: white !important;
        }
        .delete-link {
            color: red;
            cursor: pointer;
        }
        input[type="text"], input[type="date"] {
            border: 1px solid #ccc;
        }
        .upload-icon-box {
            width: 120px;
            height: 120px;
            border: 2px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 48px;
            border-radius: 20px;
            background-color: #f8f9fa;
            cursor: pointer;
            margin: 20px;
        }
        .cv-form-item {
            margin: 20px;
        }
        .cv-section .border {
            border-width: 2px !important;
            
        }
        label {
            color: #6c757d; /* abu-abu Bootstrap */
        }
</style>
@endpush

    <div class="card">
        <h5>Update your CV</h5>
        <div class="d-flex align-items-center border rounded p-3 flex-wrap">
            <div class="upload-icon-box" onclick="document.getElementById('cvInput').click()">+</div>
            <form action="{{ route('cv.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center">
                @csrf
                <input type="file" name="cv" hidden id="cvInput">
                <button type="button" class="btn btn-upload cv-form-item" onclick="document.getElementById('cvInput').click()">Upload File</button>
                <span class="ms-2 cv-form-item">Job_required.pdf</span>
                <a class="ms-2 delete-link cv-form-item text-decoration-none">Delete</a>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <h5>Education</h5>
        <form action="{{ route('education.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label>School/University</label>
                    <input type="text" name="school" class="form-control" value="University of Oxford">
                </div>
                <div class="col">
                    <label>Major</label>
                    <input type="text" name="major" class="form-control" value="Computer Science">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>From</label>
                    <input type="date" name="from" class="form-control" value="2022-09-17">
                </div>
                <div class="col">
                    <label>To</label>
                    <input type="date" name="to" class="form-control" value="2024-09-17">
                </div>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-app-layout>