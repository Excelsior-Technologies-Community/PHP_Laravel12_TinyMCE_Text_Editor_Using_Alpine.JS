<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TinyMCE Editor</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl p-8 space-y-6" x-data="editorApp()">
        
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <div class="text-center sm:text-left">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-2">TinyMce Text Editor</h1>
                <p class="text-gray-500">Laravel 12 + TinyMCE + Alpine.js</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="px-4 py-2 text-sm font-semibold rounded-full transition-all duration-300"
                      :class="saveStatus === 'Draft Saved' ? 'bg-green-100 text-green-700' : (saveStatus ? 'bg-yellow-100 text-yellow-700' : 'bg-transparent')"
                      x-text="saveStatus"></span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('editor.store') }}" class="space-y-4">
            @csrf

            <textarea id="editor" name="content" class="hidden">{{ $content->content ?? '' }}</textarea>

            <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex space-x-6 text-sm font-medium text-gray-600 mb-4 sm:mb-0">
                    <span class="flex items-center space-x-2">
                        <span class="uppercase tracking-wider text-xs">Words:</span> 
                        <span x-text="wordCount" class="text-blue-600 font-bold text-xl">0</span>
                    </span>
                    <span class="flex items-center space-x-2">
                        <span class="uppercase tracking-wider text-xs">Chars:</span> 
                        <span x-text="charCount" class="text-blue-600 font-bold text-xl">0</span>
                    </span>
                </div>
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-2.5 rounded-lg shadow-md transition duration-200">
                    Save Content
                </button>
            </div>
        </form>

        @if($content)
            <div class="mt-8 pt-6 border-t">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Saved Content Preview</h2>
                <div class="border border-gray-200 p-6 rounded-lg bg-gray-50 shadow-sm prose max-w-none">
                    {!! $content->content !!}
                </div>
            </div>
        @endif
    </div>

    <script>
        function editorApp() {
            return {
                content: `{!! addslashes($content->content ?? '') !!}`,
                wordCount: 0,
                charCount: 0,
                saveStatus: '',
                saveTimeout: null,

                init() {
                    let app = this;
                    tinymce.init({
                        selector: '#editor',
                        height: 500,
                        menubar: true,
                        plugins: 'lists link image table code wordcount preview',
                        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code | preview',
                        branding: false,
                        skin: 'oxide',
                        content_css: 'default',
                        setup: function (editor) {
                            editor.on('init', function () {
                                app.updateCounters(editor);
                            });
                            editor.on('keyup change', function () {
                                app.content = editor.getContent();
                                app.updateCounters(editor);
                                app.triggerAutoSave();
                            });
                        }
                    });
                },

                updateCounters(editor) {
                    let text = editor.getContent({ format: 'text' });
                    this.charCount = text.length;
                    
                    let words = text.trim().split(/\s+/).filter(word => word.length > 0);
                    this.wordCount = text.trim() === '' ? 0 : words.length;
                },

                triggerAutoSave() {
                    this.saveStatus = 'Saving...';
                    clearTimeout(this.saveTimeout);
                    
                    this.saveTimeout = setTimeout(() => {
                        axios.post('{{ route("editor.autosave") }}', {
                            content: this.content,
                            _token: '{{ csrf_token() }}'
                        }).then(res => {
                            this.saveStatus = 'Draft Saved';
                        }).catch(err => {
                            this.saveStatus = 'Error Saving';
                        });
                    }, 2000);
                }
            }
        }
    </script>
</body>

</html>