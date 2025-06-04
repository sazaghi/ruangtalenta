<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.07);
            margin-top: 50px;
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Job Post</h2>
        <form action="#" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" value="Software Engineer" required>
                <div class="invalid-feedback">
                    Please provide a job title.
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>We are looking for a highly motivated and skilled Software Engineer to join our dynamic team. You will be responsible for developing high-quality software solutions, from design to deployment. Strong problem-solving skills and experience with modern web technologies are essential. </textarea>
                <div class="invalid-feedback">
                    Please provide a job description.
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="salary" class="form-label">Salary (IDR)</label>
                    <input type="number" class="form-control" id="salary" name="salary" value="12000000" required min="0">
                    <div class="invalid-feedback">
                        Please provide a valid salary.
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="Yogyakarta, Indonesia" placeholder="e.g., Jakarta, Indonesia">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="experience" class="form-label">Experience Required (Years)</label>
                    <input type="number" class="form-control" id="experience" name="experience" value="3" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="job_type" class="form-label">Job Type</label>
                    <select class="form-select" id="job_type" name="job_type">
                        <option value="">Select Job Type</option>
                        <option value="Full-time" selected>Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="deadline" class="form-label">Application Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" value="2025-07-31">
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Job</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>