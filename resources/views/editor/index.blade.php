<!DOCTYPE html>
<html>

<head>
    <title>Editor Dashboard</title>

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

        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 14px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .green { background: #22c55e; }
        .gray { background: #6b7280; }
        .yellow { background: #f59e0b; }
        .red { background: #ef4444; }

        .table-box {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            text-align: left;
        }

        .badge {
            background: #e0e7ff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #3730a3;
        }

        .actions form {
            display: inline;
        }

        .actions button {
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            background: #ef4444;
            color: white;
        }

        .actions button:hover {
            background: #dc2626;
        }

        /* ✅ Success Message Style */
        .alert-success {
            background:#d1fae5;
            color:#065f46;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
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

    <div class="topbar">
        <h2>📄 Dashboard</h2>

        <div>
            <form method="GET" action="{{ route('editor.index') }}" style="display:inline;">
                <input type="text" name="search" placeholder="Search...">
                <button class="btn gray">Search</button>
            </form>

            <a href="{{ route('editor.create') }}" class="btn green">+ New</a>
            <a href="{{ route('editor.trash') }}" class="btn gray">Trash</a>
        </div>
    </div>

    <!-- ✅ SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" style="
                background:none;
                border:none;
                font-size:16px;
                cursor:pointer;
            ">✖</button>
        </div>
    @endif

    <div class="table-box">

        <table>
            <tr>
                <th>ID</th>
                <th>Content</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            @foreach($contents as $item)
            <tr>
                <td><span class="badge">#{{ $item->id }}</span></td>
                <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->content), 80) !!}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td class="actions">

                    <a href="{{ route('editor.edit', $item->id) }}" class="btn yellow">Edit</a>

                    <form action="{{ route('editor.delete', $item->id) }}" method="POST" onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn red">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach

        </table>

    </div>

</div>

<!-- ✅ SCRIPT -->
<script>
function confirmDelete() {
    return confirm("⚠️ Are you sure you want to delete this content?");
}

// ✅ Auto hide success message
setTimeout(() => {
    let alert = document.querySelector('.alert-success');
    if(alert){
        alert.style.transition = "0.5s";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>

</body>
</html>