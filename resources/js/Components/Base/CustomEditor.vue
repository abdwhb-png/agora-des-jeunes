<template>
    <Editor
        :value="modelValue"
        @load="onEditorLoad"
        @text-change="onChange"
        ref="editor"
    />
</template>

<script setup>
import { ref } from "vue";
import { useToast } from "@/Components/ui/toast/use-toast";
import { useAxios } from "@/composables/useAxios";

defineProps({
    modelValue: String,
});

const emits = defineEmits(["update:modelValue"]);

const editor = ref();

const onEditorLoad = (event) => {
    // Add custom image handler
    const toolbar = event.instance.getModule("toolbar");
    toolbar.addHandler("image", handleImageUpload);
};

const onChange = (event) => {
    // console.log(event);
    emits("update:modelValue", event.htmlValue);
};

const handleImageUpload = () => {
    const input = document.createElement("input");
    input.setAttribute("type", "file");
    input.setAttribute("accept", "image/*");
    input.click();

    input.onchange = async () => {
        const file = input.files[0];
        if (file) {
            const imageUrl = await upload(file);
            if (imageUrl) {
                const quill = editor.value.quill;
                const range = quill.getSelection();

                // Insert the image URL into the editor using the editor instance provided
                quill.insertEmbed(range.index, "image", imageUrl);

                // Move cursor after the inserted image
                quill.setSelection(range.index + 1);

                this.form.content = quill.root.innerHTML;
            }
        }
    };
};

async function upload(file) {
    const formData = new FormData();
    formData.append("image", file);
    const { uploadImage } = useAxios();
    return uploadImage(formData);
}
</script>
