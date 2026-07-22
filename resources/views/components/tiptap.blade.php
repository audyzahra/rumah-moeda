@props([
    'name' => 'content',
    'value' => '',
    'placeholder' => 'Tulis isi berita di sini...'
])

<div
    class="tiptap-wrapper"
    data-upload-url="{{ route('admin.editor.upload') }}"
>

    {{-- Toolbar --}}
    <div class="tiptap-toolbar">

        <button type="button" data-action="bold" title="Bold">
            <i class="fa-solid fa-bold"></i>
        </button>

        <button type="button" data-action="italic" title="Italic">
            <i class="fa-solid fa-italic"></i>
        </button>

        <button type="button" data-action="underline" title="Underline">
            <i class="fa-solid fa-underline"></i>
        </button>

        <div class="divider"></div>

        <button type="button" data-action="h2">
            H2
        </button>

        <button type="button" data-action="h3">
            H3
        </button>

        <div class="divider"></div>

        <button type="button" data-action="bulletList" title="Bullet List">
            <i class="fa-solid fa-list-ul"></i>
        </button>

        <button type="button" data-action="orderedList" title="Number List">
            <i class="fa-solid fa-list-ol"></i>
        </button>

        <button type="button" data-action="taskList" title="Checklist">
            <i class="fa-solid fa-square-check"></i>
        </button>

        <div class="divider"></div>

        <button type="button" data-action="blockquote" title="Quote">
            <i class="fa-solid fa-quote-left"></i>
        </button>

        <button type="button" data-action="link" title="Link">
            <i class="fa-solid fa-link"></i>
        </button>

        {{-- Upload Image --}}
        <button
            type="button"
            data-action="image"
            title="Upload Image"
        >
            <i class="fa-solid fa-image"></i>
        </button>

        <div class="divider"></div>

        <button type="button" data-action="undo" title="Undo">
            <i class="fa-solid fa-rotate-left"></i>
        </button>

        <button type="button" data-action="redo" title="Redo">
            <i class="fa-solid fa-rotate-right"></i>
        </button>

    </div>

    {{-- Editor --}}
    <div
        class="tiptap-editor"
        data-placeholder="{{ $placeholder }}"
    ></div>

    {{-- Hidden Content --}}
    <input
        type="hidden"
        name="{{ $name }}"
        value="{{ $value }}"
        class="tiptap-content"
    >

    {{-- Hidden Upload --}}
    <input
        type="file"
        class="tiptap-image-input"
        accept="image/png,image/jpeg,image/jpg,image/webp"
        hidden
    >

</div>
