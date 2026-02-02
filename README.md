# PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS

##  Introduction

This project demonstrates how to integrate a TinyMCE WYSIWYG HTML editor into a Laravel 12 application using Alpine.js for lightweight reactivity. Users can write, edit, and save rich HTML content directly from the browser. The saved content is stored safely in a database and can be previewed instantly. This setup provides a modern, interactive text editing experience within a clean MVC structure.

---

##  Project Overview

The PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS project allows developers to quickly implement a rich text editor in Laravel applications. Key functionalities include:

- TinyMCE editor for HTML content creation.

- Alpine.js integration for reactive UI behavior.

- Database storage for content with safe display.

- Clean MVC architecture, making it easy to extend for blogs, CMS, or admin panels.

###  Features

* Laravel 12 project structure (latest)
* TinyMCE rich text editor
* Alpine.js for frontend reactivity
* Store & display HTML content safely
* Clean MVC structure


---

##  Requirements

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL 
* Laravel CLI (optional)

---

##  Step 1: Create Laravel 12 Project

Run the following command:

```bash
composer create-project laravel/laravel PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS "12.*"
```

Navigate to the project:

```bash
cd PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS
```

---

##  Step 2: Configure Database

Update **.env** file:

```env
DB_DATABASE=tinymce_editor
DB_USERNAME=root
DB_PASSWORD=
```

Create database manually:

```sql
CREATE DATABASE tinymce_editor;
```

Or Using this command to create databse:

```bash
php artisan migrate
```

---

##  Step 3: Install Frontend Dependencies

###  Install default frontend dependencies:

```bash
npm install
npm run dev
```

###  Install Alpine.js

Run the following command:

```bash
npm install alpinejs
```

---

##  Step 4: Configure Alpine.js

Open **resources/js/app.js** and update it as follows:

```js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
```

Now rebuild assets:

```bash
npm run dev
```

Alpine.js is now properly installed and ready to use in Blade files.

---

##  Step 5: Create Migration & Model

```bash
php artisan make:model EditorContent -m
```

###  Migration File

**database/migrations/xxxx_create_editor_contents_table.php**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('editor_contents', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editor_contents');
    }
};
```

Run migration:

```bash
php artisan migrate
```

###  Model

**app/Models/EditorContent.php**

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];
}
```
---


##  Step 6: Create Controller

```bash
php artisan make:controller EditorController
```

###  Controller Code

**app/Http/Controllers/EditorController.php**

```php
<?php

namespace App\Http\Controllers;


use App\Models\EditorContent;
use Illuminate\Http\Request;


class EditorController extends Controller
{
    public function index()
    {
        $content = EditorContent::latest()->first();
        return view('editor', compact('content'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);


        EditorContent::create([
            'content' => $request->input('content')        
            ]);


        return redirect()->back()->with('success', 'Content saved successfully');
    }
}
```

---

##  Step 7: Define Routes

**routes/web.php**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;


Route::get('/', [EditorController::class, 'index']);
Route::post('/store', [EditorController::class, 'store'])->name('editor.store');
```

---

##  Step 8: Create Blade View

```bash
touch resources/views/editor.blade.php
```

###  Blade File

**resources/views/editor.blade.php**

```html
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
```

##  Step 9: Add key in .env

```.env
TINYMCE_API_KEY=your_real_api_key_here
```

##  Step 10: Create a TinyMCE API Key

To use TinyMCE in your project, you need a valid API key.

###  Step 1: Go to Tiny Cloud

Open your browser and visit:

https://www.tiny.cloud/

Click “Get Started Free” or “Sign Up” to create an account if you don’t have one.


###  Step 2: Sign Up / Log In

Sign up with your email (free plan is enough).

If you already have an account, simply log in.


###  Step 3: Configure the API Key

Give the key a name (example: LaravelLocalEditor).

Add allowed domains for your project:

```
http://127.0.0.1:8000
http://localhost:8000   (optional if using localhost)
```

###  Step 4: Integrate TinyMCE

Use your API key to set up your Tiny Cloud installation:

Copy the key provided by TinyMCE.

Example:

```
abcdef1234567890abcdef1234567890
```

---

##  Project Structure

```
PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── EditorController.php        # Handles storing and displaying editor content
│   └── Models/
│       └── EditorContent.php               # Eloquent model for the editor content
│
├── database/
│   ├── migrations/
│   │   └── 2026_02_02_000000_create_editor_contents_table.php
│   │       # Migration file for creating the "editor_contents" table
│   │       # Table columns: id, content (longText), created_at, updated_at
│
├── resources/
│   ├── views/
│   │   └── editor.blade.php                # Main Blade view with TinyMCE editor
│   └── js/
│       └── app.js                          # Import Alpine.js 
│
├── routes/
│   └── web.php                             # Defines routes for the editor (show form, store content)
│
├── .env                                    # Environment configuration (DB, app settings)
├── README.md                               # Project description, setup instructions, notes
└── package.json                            # Node.js dependencies (Tailwind, Alpine.js, etc.)
```

---

## Output

### TinyMce Text Editor

<img width="1815" height="1091" alt="Screenshot 2026-02-02 122559" src="https://github.com/user-attachments/assets/a64d6b23-31a5-4995-a468-5d2de8c59a25" />

### Write Html Text

<img width="1817" height="1086" alt="Screenshot 2026-02-02 122649" src="https://github.com/user-attachments/assets/bb028049-79a6-4d36-b0a2-9f78cbc15a65" />


* User writes HTML content using TinyMCE
* Content saved in database
* Content preview rendered safely


---

Your PHP_Laravel12_TinyMCE_Text_Editor_Using_Alpine.JS Project is Now Ready!

