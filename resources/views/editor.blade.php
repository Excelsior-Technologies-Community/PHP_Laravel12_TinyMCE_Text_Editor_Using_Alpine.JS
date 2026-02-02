<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TinyMCE Editor</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl p-8 space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">TinyMce Text Editor</h1>
            <p class="text-gray-500">Laravel 12 + TinyMCE + Alpine.js</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('editor.store') }}" x-data class="space-y-4">
            @csrf

            <!-- TinyMCE Textarea -->
            <textarea id="editor" name="content" class="hidden">{{ $content->content ?? '' }}</textarea>

            <!-- Save Button -->
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-200">
                    Save Content
                </button>
            </div>
        </form>

        <!-- Saved Content Preview -->
        @if($content)
            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Saved Content Preview</h2>
                <div class="border border-gray-200 p-6 rounded-lg bg-gray-50 shadow-sm">
                    {!! $content->content !!}
                </div>
            </div>
        @endif
    </div>

    <!-- TinyMCE Init -->
    <script>
        tinymce.init({
            selector: '#editor',
            height: 400,
            menubar: true,
            plugins: 'lists link image table code wordcount preview',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code | preview',
            branding: false,
            skin: 'oxide',
            content_css: 'default'
        });
    </script>

</body>

</html>