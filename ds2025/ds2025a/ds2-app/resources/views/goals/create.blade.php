@extends('layouts.app')

@section('title', 'Create Goal')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Create a New Goal</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('goals.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="studies" {{ old('category') == 'studies' ? 'selected' : '' }}>Studies</option>
                            <option value="sport" {{ old('category') == 'sport' ? 'selected' : '' }}>Sport</option>
                            <option value="reading" {{ old('category') == 'reading' ? 'selected' : '' }}>Reading</option>
                            <option value="projects" {{ old('category') == 'projects' ? 'selected' : '' }}>Projects</option>
                            <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>Health</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="visibility" class="form-label">Visibility</label>
                        <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="friends" {{ old('visibility') == 'friends' ? 'selected' : '' }}>Friends</option>
                            <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                        @error('visibility')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline (Optional)</label>
                        <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') }}">
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary" onclick="suggestSteps()">Suggest Steps (AI)</button>
                        <div id="suggested-steps" class="mt-2"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create Goal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    function suggestSteps() {
        // Mock AI suggestions (replace with OpenAI/Gemini API call)
        const suggestions = [
            "Step 1: Research and plan your goal",
            "Step 2: Set milestones and deadlines",
            "Step 3: Track progress weekly",
        ];
        document.getElementById('suggested-steps').innerHTML = `
            <div class="alert alert-info">
                <strong>Suggested Steps:</strong>
                <ul class="list-group mt-2">
                    ${suggestions.map(step => `<li class="list-group-item">${step}</li>`).join('')}
                </ul>
            </div>
        `;
        // Example OpenAI API call (requires API key):
        
        fetch('https://api.openai.com/v1/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer YOUR_API_KEY'
            },
            body: JSON.stringify({
                model: 'text-davinci-003',
                prompt: 'Suggest 3 intermediate steps for the goal: ' + document.getElementById('title').value,
                max_tokens: 100
            })
        }).then(response => response.json()).then(data => {
            // Process AI response
        });
        
    }
</script>
@endsection