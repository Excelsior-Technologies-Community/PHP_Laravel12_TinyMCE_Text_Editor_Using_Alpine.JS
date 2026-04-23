<!DOCTYPE html>
<html>

<head>
    <title>Trash - Editor CMS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 22px;
            color: #111827;
        }

        /* BUTTONS */
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .green { background: #22c55e; color: white; }
        .red { background: #ef4444; color: white; }
        .blue { background: #3b82f6; color: white; }

        .btn:hover {
            opacity: 0.9;
        }

        /* CARD */
        .card {
            background: white;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            max-width: 70%;
            font-size: 14px;
            color: #374151;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

    </style>
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

    <div class="header">
        <h2>🗑️ Trash Items</h2>

        <a href="{{ route('editor.index') }}" class="btn blue">← Back to Dashboard</a>
    </div>
@if(session('success'))
    <div style="
        background: #dcfce7;
        color: #166534;
        border: 1px solid #22c55e;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
    ">
        <span>✅ {{ session('success') }}</span>

        <button onclick="this.parentElement.remove()" style="
            background: transparent;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #166534;
        ">✖</button>
    </div>
@endif
    @if($contents->count() == 0)
        <div class="card">
            <div class="content">
                No trashed content found.
            </div>
        </div>
    @endif

    @foreach($contents as $item)
        <div class="card">

            <div class="content">
                {!! Str::limit(strip_tags($item->content), 120) !!}
            </div>

            <div class="actions">

                <a href="{{ route('editor.restore', $item->id) }}" class="btn green">
                    Restore
                </a>

                <a href="{{ route('editor.forceDelete', $item->id) }}" class="btn red"
                   onclick="return confirm('Are you sure you want to permanently delete this?')">
                    Delete Forever
                </a>

            </div>

        </div>
    @endforeach

</div>

</body>
</html>