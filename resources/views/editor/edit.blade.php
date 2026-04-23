<!DOCTYPE html>
<html>

<head>
    <title>Edit Content</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: #f4f6fb;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #111827;
            position: fixed;
            padding: 20px;
            color: white;
        }

        .menu a {
            display: block;
            padding: 12px;
            color: #cbd5e1;
            text-decoration: none;
        }

        .menu a:hover {
            background: #1f2937;
        }

        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        .btn {
            background: #f59e0b;
            color: white;
            padding: 10px 14px;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>

    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js"></script>
</head>

<body>

<div class="sidebar">
    <h3>📝 Editor CMS</h3>

    <div class="menu">
        <a href="{{ route('editor.index') }}">🏠 Dashboard</a>
        <a href="{{ route('editor.create') }}">➕ Create</a>
        <a href="{{ route('editor.trash') }}">🗑️ Trash</a>
    </div>
</div>

<div class="main">

    <div class="box">

        <h2>✏️ Edit Content</h2>

        <form method="POST" action="{{ route('editor.update', $content->id) }}">
            @csrf
            @method('PUT')

            <textarea id="editor" name="content">{!! $content->content !!}</textarea>

            <button class="btn">Update</button>
        </form>

    </div>

</div>

<script>
tinymce.init({
    selector: '#editor',
    height: 400
});
</script>

</body>
</html>