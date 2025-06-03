<template>
	<div v-if="editor" class="bg-white rounded-md w-full border-0 shadow ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ">
		<menu class="flex">
			<li>
				<button 
					@click="() => editor.chain().focus().toggleBold().run()"
					:class="[
						editor.isActive('bold') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Bold"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M8 11H12.5C13.8807 11 15 9.88071 15 8.5C15 7.11929 13.8807 6 12.5 6H8V11ZM18 15.5C18 17.9853 15.9853 20 13.5 20H6V4H12.5C14.9853 4 17 6.01472 17 8.5C17 9.70431 16.5269 10.7981 15.7564 11.6058C17.0979 12.3847 18 13.837 18 15.5ZM8 13V18H13.5C14.8807 18 16 16.8807 16 15.5C16 14.1193 14.8807 13 13.5 13H8Z"></path></svg>
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleItalic().run()"
					:class="[
						editor.isActive('italic') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M15 20H7V18H9.92661L12.0425 6H9V4H17V6H14.0734L11.9575 18H15V20Z"></path></svg>
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleUnderline().run()"
					:class="[
						editor.isActive('underline') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
				>
				 	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M8 3V12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12V3H18V12C18 15.3137 15.3137 18 12 18C8.68629 18 6 15.3137 6 12V3H8ZM4 20H20V22H4V20Z"></path></svg> 
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleStrike().run()"
					:class="[
						editor.isActive('strike') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Strikethrough"
				>
				 	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  width="16" height="16"  fill="currentColor"><path d="M17.1538 14C17.3846 14.5161 17.5 15.0893 17.5 15.7196C17.5 17.0625 16.9762 18.1116 15.9286 18.867C14.8809 19.6223 13.4335 20 11.5862 20C9.94674 20 8.32335 19.6185 6.71592 18.8555V16.6009C8.23538 17.4783 9.7908 17.917 11.3822 17.917C13.9333 17.917 15.2128 17.1846 15.2208 15.7196C15.2208 15.0939 15.0049 14.5598 14.5731 14.1173C14.5339 14.0772 14.4939 14.0381 14.4531 14H3V12H21V14H17.1538ZM13.076 11H7.62908C7.4566 10.8433 7.29616 10.6692 7.14776 10.4778C6.71592 9.92084 6.5 9.24559 6.5 8.45207C6.5 7.21602 6.96583 6.165 7.89749 5.299C8.82916 4.43299 10.2706 4 12.2219 4C13.6934 4 15.1009 4.32808 16.4444 4.98426V7.13591C15.2448 6.44921 13.9293 6.10587 12.4978 6.10587C10.0187 6.10587 8.77917 6.88793 8.77917 8.45207C8.77917 8.87172 8.99709 9.23796 9.43293 9.55079C9.86878 9.86362 10.4066 10.1135 11.0463 10.3004C11.6665 10.4816 12.3431 10.7148 13.076 11H13.076Z"></path></svg> 
				</button>
			
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleBlockquote().run()"
					:class="[
						editor.isActive('blockquote') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Blockquote"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  width="16" height="16" fill="currentColor"><path d="M3.41436 5.99995L5.70726 3.70706L4.29304 2.29285L0.585938 5.99995L4.29304 9.70706L5.70726 8.29285L3.41436 5.99995ZM9.58594 5.99995L7.29304 3.70706L8.70726 2.29285L12.4144 5.99995L8.70726 9.70706L7.29304 8.29285L9.58594 5.99995ZM14.0002 2.99995H21.0002C21.5524 2.99995 22.0002 3.44767 22.0002 3.99995V20C22.0002 20.5522 21.5524 21 21.0002 21H3.00015C2.44787 21 2.00015 20.5522 2.00015 20V12H4.00015V19H20.0002V4.99995H14.0002V2.99995Z"></path></svg>				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleBulletList().run()"
					:class="[
						editor.isActive('bulletList') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Bullet List"
				>
				 	<svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16"  viewBox="0 0 24 24" fill="currentColor"><path d="M8 4H21V6H8V4ZM4.5 6.5C3.67157 6.5 3 5.82843 3 5C3 4.17157 3.67157 3.5 4.5 3.5C5.32843 3.5 6 4.17157 6 5C6 5.82843 5.32843 6.5 4.5 6.5ZM4.5 13.5C3.67157 13.5 3 12.8284 3 12C3 11.1716 3.67157 10.5 4.5 10.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5ZM4.5 20.4C3.67157 20.4 3 19.7284 3 18.9C3 18.0716 3.67157 17.4 4.5 17.4C5.32843 17.4 6 18.0716 6 18.9C6 19.7284 5.32843 20.4 4.5 20.4ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path></svg>
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleOrderedList().run()"
					:class="[
						editor.isActive('orderedList') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Numeric List"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  width="16" height="16"  fill="currentColor"><path d="M5.75024 3.5H4.71733L3.25 3.89317V5.44582L4.25002 5.17782L4.25018 8.5H3V10H7V8.5H5.75024V3.5ZM10 4H21V6H10V4ZM10 11H21V13H10V11ZM10 18H21V20H10V18ZM2.875 15.625C2.875 14.4514 3.82639 13.5 5 13.5C6.17361 13.5 7.125 14.4514 7.125 15.625C7.125 16.1106 6.96183 16.5587 6.68747 16.9167L6.68271 16.9229L5.31587 18.5H7V20H3.00012L2.99959 18.8786L5.4717 16.035C5.5673 15.9252 5.625 15.7821 5.625 15.625C5.625 15.2798 5.34518 15 5 15C4.67378 15 4.40573 15.2501 4.37747 15.5688L4.3651 15.875H2.875V15.625Z"></path></svg>
				</button>
			</li>
			<li>
				<button 
					@click="() => promptUserForHref()"
					:class="[
						editor.isActive('link') ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Add Link"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="16px" width="16px" fill="currentColor"><path d="M18.3638 15.5355L16.9496 14.1213L18.3638 12.7071C20.3164 10.7545 20.3164 7.58866 18.3638 5.63604C16.4112 3.68341 13.2453 3.68341 11.2927 5.63604L9.87849 7.05025L8.46428 5.63604L9.87849 4.22182C12.6122 1.48815 17.0443 1.48815 19.778 4.22182C22.5117 6.95549 22.5117 11.3876 19.778 14.1213L18.3638 15.5355ZM15.5353 18.364L14.1211 19.7782C11.3875 22.5118 6.95531 22.5118 4.22164 19.7782C1.48797 17.0445 1.48797 12.6123 4.22164 9.87868L5.63585 8.46446L7.05007 9.87868L5.63585 11.2929C3.68323 13.2455 3.68323 16.4113 5.63585 18.364C7.58847 20.3166 10.7543 20.3166 12.7069 18.364L14.1211 16.9497L15.5353 18.364ZM14.8282 7.75736L16.2425 9.17157L9.17139 16.2426L7.75717 14.8284L14.8282 7.75736Z"></path></svg>
				</button>
			</li>
			<li>
				<button
					@click="() => editor.chain().focus().toggleHeading({level: 2}).run()"
					:class="[
						editor.isActive('heading', {level:2}) ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Heading 1"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M13 20H11V13H4V20H2V4H4V11H11V4H13V20ZM21.0005 8V20H19.0005L19 10.204L17 10.74V8.67L19.5005 8H21.0005Z"></path></svg>
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleHeading({level: 3}).run()"
					:class="[
						editor.isActive('heading', {level: 3}) ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Heading 2"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M4 4V11H11V4H13V20H11V13H4V20H2V4H4ZM18.5 8C20.5711 8 22.25 9.67893 22.25 11.75C22.25 12.6074 21.9623 13.3976 21.4781 14.0292L21.3302 14.2102L18.0343 18H22V20H15L14.9993 18.444L19.8207 12.8981C20.0881 12.5908 20.25 12.1893 20.25 11.75C20.25 10.7835 19.4665 10 18.5 10C17.5818 10 16.8288 10.7071 16.7558 11.6065L16.75 11.75H14.75C14.75 9.67893 16.4289 8 18.5 8Z"></path></svg>							
				</button>
			</li>
			<li>
				<button 
					@click="() => editor.chain().focus().toggleHeading({level: 4}).run()"
					:class="[
						editor.isActive('heading',{level: 4}) ?'bg-gray-300 hover:bg-gray-300':'bg-gray-100 border hover:bg-gray-200' 
					]"
					class="rounded-tl p-2 font-bold "
					type="button" 
					title="Heading 3"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M22 8L21.9984 10L19.4934 12.883C21.0823 13.3184 22.25 14.7728 22.25 16.5C22.25 18.5711 20.5711 20.25 18.5 20.25C16.674 20.25 15.1528 18.9449 14.8184 17.2166L16.7821 16.8352C16.9384 17.6413 17.6481 18.25 18.5 18.25C19.4665 18.25 20.25 17.4665 20.25 16.5C20.25 15.5335 19.4665 14.75 18.5 14.75C18.214 14.75 17.944 14.8186 17.7056 14.9403L16.3992 13.3932L19.3484 10H15V8H22ZM4 4V11H11V4H13V20H11V13H4V20H2V4H4Z"></path></svg>
				</button>
			</li>
			<slot name="toolbar" :editor="editor"/>
		</menu>
		<EditorContent :editor="editor"/>
	</div>
</template>
<script setup>
import { EditorContent, useEditor } from '@tiptap/vue-3';
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link';
import { StarterKit } from '@tiptap/starter-kit';
import { Markdown } from 'tiptap-markdown'
import { watch } from 'vue';
import Placeholder from '@tiptap/extension-placeholder';

let props = defineProps({
	modelValue: '',
	editorClass: '', 
	placeholder: null,
});

let emit = defineEmits(['update:modelValue']);

const editor = useEditor({
	extensions: [
		StarterKit.configure({
			heading: {
				levels: [ 2,3,4 ]
			}
		}),
		Markdown,
		Underline,
		Link,
		Placeholder.configure({
			placeholder: props.placeholder
		})
	],
	editorProps: {
		attributes: {
		  	class: `min-h-[500px] prose prose-sm py-1.5 px-3 max-w-none ${props.editorClass}`,
		},
	},
	onUpdate: () => emit('update:modelValue', editor.value?.storage.markdown.getMarkdown()),
});

watch(() => props.modelValue, (value) => {
	if (value === editor.value?.storage.markdown.getMarkdown()) {
		return;
	}
	editor.value?.commands.setContent(value)
}, { immediate: true });

let promptUserForHref = () => {
	if(editor.value?.isActive('link')){
		return editor.value?.chain().unsetLink().run();
	}

	let href = window.prompt('Where do you want to link?');
	if (!href){
		return editor.value?.chain().focus().run();
	}
	return editor.value?.chain().focus().setLink({href}).run();
};
</script>

<style scoped>
	:deep(.tiptap p.is-editor-empty:first-child::before) {
		--tw-text-opacity: 1;
		color: rgb(156 163 175 / var(--tw-text-opacity, 1)) /* #9ca3af */;
		float: left;
		/* height: 0; */
		pointer-events: none;
		content: attr(data-placeholder);
	}
</style>