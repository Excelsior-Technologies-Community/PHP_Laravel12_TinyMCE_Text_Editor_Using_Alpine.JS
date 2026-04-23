<!DOCTYPE html>
<html>
<head>
    <title>Create Content</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: #f4f6fb;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #111827;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            color: white;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .menu a {
            display: block;
            padding: 12px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .menu a:hover {
            background: #1f2937;
            color: white;
        }

        /* MAIN */
        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .btn {
            background: #22c55e;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #3b82f6;
        }
    </style>

    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js"></script>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">📝 Editor CMS</div>

    <div class="menu">
        <a href="{{ route('editor.index') }}">🏠 Dashboard</a>
        <a href="{{ route('editor.create') }}">➕ Create</a>
        <a href="{{ route('editor.trash') }}">🗑️ Trash</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <div class="box">

        <h2>➕ Create New Content</h2>

        <a href="{{ route('editor.index') }}">← Back</a>

        <form method="POST" action="{{ route('editor.store') }}">
            @csrf

            <textarea id="editor" name="content"></textarea>

            <button class="btn">Save</button>
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