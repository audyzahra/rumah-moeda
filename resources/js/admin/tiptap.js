import { Editor } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";

import Underline from "@tiptap/extension-underline";
import Link from "@tiptap/extension-link";
import Placeholder from "@tiptap/extension-placeholder";
import TaskList from "@tiptap/extension-task-list";
import TaskItem from "@tiptap/extension-task-item";
import TextAlign from "@tiptap/extension-text-align";
import Highlight from "@tiptap/extension-highlight";
import Image from "@tiptap/extension-image";

function initTiptap() {

    const wrappers = document.querySelectorAll(".tiptap-wrapper");

    if (!wrappers.length) {
        return;
    }

    wrappers.forEach((wrapper) => {

        const editorElement = wrapper.querySelector(".tiptap-editor");
        const hiddenInput = wrapper.querySelector(".tiptap-content");

        if (!editorElement || !hiddenInput) {
            return;
        }

        const editor = new Editor({

            element: editorElement,

            content: hiddenInput.value || "",

            autofocus: false,

            editable: true,

            injectCSS: false,

            extensions: [

                StarterKit.configure({
                    heading: {
                        levels: [2, 3],
                    },
                }),

                Underline,

                Highlight,

                Image.configure({
                    inline: false,
                    allowBase64: true,
                }),

                Link.configure({
                    openOnClick: false,
                    autolink: true,
                    linkOnPaste: true,
                    defaultProtocol: "https",
                }),

                Placeholder.configure({
                    placeholder:
                        editorElement.dataset.placeholder ||
                        "Tulis isi berita di sini...",
                    emptyEditorClass: "is-editor-empty",
                }),

                TaskList,

                TaskItem.configure({
                    nested: true,
                }),

                TextAlign.configure({
                    types: [
                        "heading",
                        "paragraph",
                    ],
                }),

            ],

            editorProps: {
                attributes: {
                    class: "ProseMirror",
                },
            },

            onCreate({ editor }) {

                hiddenInput.value = editor.getHTML();

                updateToolbar(editor, wrapper);

            },

            onUpdate({ editor }) {

                hiddenInput.value = editor.getHTML();

                updateToolbar(editor, wrapper);

            },

            onSelectionUpdate({ editor }) {

                updateToolbar(editor, wrapper);

            },

        });

        wrapper.editor = editor;

        editorElement.addEventListener("dragover", (e) => {
            e.preventDefault();
        });

        editorElement.addEventListener("drop", async (e) => {

            e.preventDefault();

            const file = e.dataTransfer.files[0];

            await handleImageFile(file, wrapper, editor);

        });

        editorElement.addEventListener("paste", async (e) => {

            const items = e.clipboardData.items;

            for (const item of items) {

                if (item.type.startsWith("image/")) {

                    e.preventDefault();

                    const file = item.getAsFile();

                    await handleImageFile(file, wrapper, editor);

                    break;

                }

            }

        });

    });

    document.querySelectorAll("form").forEach((form) => {

        form.addEventListener("submit", () => {

            document.querySelectorAll(".tiptap-wrapper").forEach((wrapper) => {

                if (
                    wrapper.editor &&
                    wrapper.querySelector(".tiptap-content")
                ) {

                    wrapper.querySelector(".tiptap-content").value =
                        wrapper.editor.getHTML();

                }

            });

        });

    });

}
/*
|--------------------------------------------------------------------------
| UPDATE TOOLBAR
|--------------------------------------------------------------------------
*/

function updateToolbar(editor, wrapper) {

    wrapper.querySelectorAll("[data-action]").forEach((button) => {

        const action = button.dataset.action;

        let active = false;

        switch (action) {

            case "bold":
                active = editor.isActive("bold");
                break;

            case "italic":
                active = editor.isActive("italic");
                break;

            case "underline":
                active = editor.isActive("underline");
                break;

            case "strike":
                active = editor.isActive("strike");
                break;

            case "highlight":
                active = editor.isActive("highlight");
                break;

            case "h2":
                active = editor.isActive("heading", {
                    level: 2,
                });
                break;

            case "h3":
                active = editor.isActive("heading", {
                    level: 3,
                });
                break;

            case "bulletList":
                active = editor.isActive("bulletList");
                break;

            case "orderedList":
                active = editor.isActive("orderedList");
                break;

            case "taskList":
                active = editor.isActive("taskList");
                break;

            case "blockquote":
                active = editor.isActive("blockquote");
                break;

            case "link":
                active = editor.isActive("link");
                break;

            case "alignLeft":
                active = editor.isActive({
                    textAlign: "left",
                });
                break;

            case "alignCenter":
                active = editor.isActive({
                    textAlign: "center",
                });
                break;

            case "alignRight":
                active = editor.isActive({
                    textAlign: "right",
                });
                break;

            case "alignJustify":
                active = editor.isActive({
                    textAlign: "justify",
                });
                break;

        }

        button.classList.toggle("is-active", active);

    });

}
/*
|--------------------------------------------------------------------------
| IMAGE UPLOAD
|--------------------------------------------------------------------------
*/

async function uploadImage(file, wrapper, editor) {

    const uploadUrl = wrapper.dataset.uploadUrl;

    const formData = new FormData();

    formData.append("image", file);

    const response = await fetch(uploadUrl, {

        method: "POST",

        headers: {

            "X-CSRF-TOKEN":
                document.querySelector('meta[name="csrf-token"]').content,

            Accept: "application/json",

        },

        body: formData,

    });

    const data = await response.json();

    if (!response.ok) {

        throw new Error(data.message || "Upload gagal.");

    }

    editor
        .chain()
        .focus()
        .setImage({
            src: data.url,
        })
        .run();

    wrapper.querySelector(".tiptap-content").value = editor.getHTML();

}
/*
|--------------------------------------------------------------------------
| HANDLE IMAGE FILE
|--------------------------------------------------------------------------
*/

async function handleImageFile(file, wrapper, editor) {

    if (!file) {
        return;
    }

    if (!file.type.startsWith("image/")) {
        return;
    }

    try {

        await uploadImage(file, wrapper, editor);

    } catch (error) {

        alert(error.message);

    }

}
/*
|--------------------------------------------------------------------------
| TOOLBAR CLICK
|--------------------------------------------------------------------------
*/

document.addEventListener("click", (e) => {

    const button = e.target.closest("[data-action]");

    if (!button) {
        return;
    }

    const wrapper = button.closest(".tiptap-wrapper");

    if (!wrapper || !wrapper.editor) {
        return;
    }

    const editor = wrapper.editor;

    const action = button.dataset.action;

    switch (action) {

        case "bold":
            editor.chain().focus().toggleBold().run();
            break;

        case "italic":
            editor.chain().focus().toggleItalic().run();
            break;

        case "underline":
            editor.chain().focus().toggleUnderline().run();
            break;

        case "strike":
            editor.chain().focus().toggleStrike().run();
            break;

        case "highlight":
            editor.chain().focus().toggleHighlight().run();
            break;

        case "h2":
            editor.chain().focus().toggleHeading({
                level: 2,
            }).run();
            break;

        case "h3":
            editor.chain().focus().toggleHeading({
                level: 3,
            }).run();
            break;

        case "bulletList":
            editor.chain().focus().toggleBulletList().run();
            break;

        case "orderedList":
            editor.chain().focus().toggleOrderedList().run();
            break;

        case "taskList":
            editor.chain().focus().toggleTaskList().run();
            break;

        case "blockquote":
            editor.chain().focus().toggleBlockquote().run();
            break;

        case "undo":
            editor.chain().focus().undo().run();
            break;

        case "redo":
            editor.chain().focus().redo().run();
            break;

        case "alignLeft":
            editor.chain().focus().setTextAlign("left").run();
            break;

        case "alignCenter":
            editor.chain().focus().setTextAlign("center").run();
            break;

        case "alignRight":
            editor.chain().focus().setTextAlign("right").run();
            break;

        case "alignJustify":
            editor.chain().focus().setTextAlign("justify").run();
            break;

        case "link": {

            const previousUrl =
                editor.getAttributes("link").href || "";

            const url = window.prompt(
                "Masukkan URL",
                previousUrl
            );

            if (url === null) {
                break;
            }

            if (url.trim() === "") {

                editor
                    .chain()
                    .focus()
                    .unsetLink()
                    .run();

                break;

            }

            editor
                .chain()
                .focus()
                .extendMarkRange("link")
                .setLink({
                    href: url,
                })
                .run();

            break;

        }
        case "image": {

            const input = wrapper.querySelector(".tiptap-image-input");

            input.value = "";

            input.click();

            break;

        }

    }

    updateToolbar(editor, wrapper);

    wrapper.querySelector(".tiptap-content").value = editor.getHTML();

});

/*
|--------------------------------------------------------------------------
| IMAGE INPUT
|--------------------------------------------------------------------------
*/

document.addEventListener("change", async (e) => {

    const input = e.target.closest(".tiptap-image-input");

    if (!input) {

        return;

    }

    const wrapper = input.closest(".tiptap-wrapper");

    const editor = wrapper.editor;

    if (!editor) {

        return;

    }

    const file = input.files[0];

    if (!file) {

        return;

    }

    try {

        await uploadImage(file, wrapper, editor);

    } catch (error) {

        alert(error.message);

    }

});
if (document.readyState === "loading") {

    document.addEventListener("DOMContentLoaded", initTiptap);

} else {

    initTiptap();

}
