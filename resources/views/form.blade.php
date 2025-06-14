<!DOCTYPE html>
<html>
<head>
    <title>AI Roadmap Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Get Your AI Roadmap</h2>
    <form method="POST" action="{{ route('submit.form') }}">
        @csrf
        <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
        <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="text" name="company_name" class="form-control mb-2" placeholder="Company Name" required>
        <input type="text" name="industry" class="form-control mb-2" placeholder="Industry">
        <select name="company_size" class="form-control mb-2" required>
            <option value="">Select Company Size</option>
            <option value="1-10">1-10</option>
            <option value="11-50">11-50</option>
            <option value="51-200">51-200</option>
            <option value="200+">200+</option>
        </select>
        <input type="text" name="job_title" class="form-control mb-3" placeholder="Job Title" required>
        <button class="btn btn-primary w-100">Start Chat</button>
    </form>
</div>
</body>
</html>
