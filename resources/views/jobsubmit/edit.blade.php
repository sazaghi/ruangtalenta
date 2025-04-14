<form action="{{ route('job.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ old('title', $job->title) }}" required>
    <textarea name="description" required>{{ old('description', $job->description) }}</textarea>
    <input type="number" name="salary" value="{{ old('salary', $job->salary) }}" required>
    <input type="text" name="location" value="{{ old('location', $job->location) }}">
    <input type="number" name="experience" value="{{ old('experience', $job->experience) }}">
    <input type="text" name="job_type" value="{{ old('job_type', $job->job_type) }}">
    <input type="date" name="deadline" value="{{ old('deadline', $job->deadline) }}">

    <button type="submit">Update Job</button>
</form>
