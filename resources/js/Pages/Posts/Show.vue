<template>
	<Head>
		<link rel="canonical" :href="post.routes.show">
	</Head>
	<AppLayout :title="post.title">
		<Container>

			<!-- post section starts -->
			 <Pill :link="route('posts.index',{topic:post.topic.slug})" >
				{{ post.topic.name }}
			 </Pill>
			<h1 class="text-2xl font-bold mt-2">{{ post.title }}</h1>
			<post-meta-data :created_at="post.created_at" :user="post.user"/>
			<div class="mt-4">
				<span class="text-red-700 font-bold text-sm flex items-center gap-1">
					{{ post.likes_count }} 
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="15px" width="15px" fill="rgba(206,4,4,1)"><path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path></svg>
				</span>
			</div>

			<article class="mt-6 prose prose-sm max-w-none" v-html="post.html"></article>

			<!-- Comment section start -->
			<div class=" w-full flex justify-center mt-8 border-t pt-8">
				<div class="max-w-screen-md w-full" >
					<h2 v-if="comments.data.length > 0" class="text-xl font-bold">Comments</h2>

					<form 
						v-if="$page.props.auth.user" 
						@submit.prevent="() => commentIdBeingEdited ? updateComment() : addComment() " 
						class="w-full mt-9"
					>
						<div >
							<MarkdownEditor  
								v-model="commentForm.body" 
								editorClass="min-h-[80px]"
								placeholder="Write what you think..."
							/>	
							<InputError :message="commentForm.errors.body"/>
						</div>

						<div class="text-right">
							<PrimaryButton 
								type="submit" 
								class="mt-5 flex" 
								:disabled="commentForm.processing"
								v-text="commentIdBeingEdited ? 'Update Comment': 'Add Comment'"
							></PrimaryButton>
							<SecondaryButton v-if="commentIdBeingEdited" class="ml-2" @click="cancelEdit()">Cancel</SecondaryButton>
						</div>
					</form>
					<div v-if="comments.data.length > 0">
						<ul class="text-left divide-y" >
							<div v-for="comment in comments.data" :key="comment.id"
								class="px-2 py-4 my-2 hover:text-blue-800 ">
								<div class="flex items-center gap-2 mb-4" >
									<span>
										<img :src="comment.user.profile_photo_path == null ? 'https://www.w3schools.com/w3images/avatar6.png' : comment.user.profile_photo_path"
											class="rounded-full h-6" />
									</span>
									<span class="font-bold text-sm"> {{ comment.user?.name }} </span>
									<span class="text-gray-600 text-xs">{{ relativeDate(comment.created_at) }} ago </span>

									<span v-if="comment.can?.delete">
										<form  @submit.prevent="deleteComment(comment.id)">
											<button 
												type="submit"
												title="Delete" 
											> 
												<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 stroke-gray-300 hover:stroke-gray-500"> <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" /> </svg>
											</button>
										</form>
									</span>
									<span v-if="comment.can?.edit">
										<button title="Edit" @click="editComment(comment.id)">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4 stroke-gray-500 hover:stroke-gray-600"> <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /> </svg>
										</button>	
									</span>
								</div>
								<div>
									<!-- <span class="text-gray-600 break-all"> {{ comment.body }}</span> -->
									 <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>
									 <div class="mt-4">
										<span class="text-red-700 font-bold text-sm flex items-center gap-1">
											{{ comment.likes_count }} 
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="15px" width="15px" fill="rgba(206,4,4,1)"><path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path></svg>
										</span>
									</div>
								</div>
							</div>
						</ul>
						<Pagination :meta="comments.meta" :only="['comments']" />
					</div>
				</div>
			</div>
		</Container>
	</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import PostMetaData from '@/Components/PostMetaData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { relativeDate } from '@/Utilities/date.js';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useConfirm } from '@/Utilities/Composables/useConfirm';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import Pill from '@/Components/Pill.vue';

let props = defineProps(['post', 'comments']);
let commentForm = useForm({
	body: '',
});

let commentIdBeingEdited = ref(null);

let commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));

let editComment = (commentId) => {
	commentIdBeingEdited.value = commentId;
	commentForm.body = commentBeingEdited.value?.body;
};

let cancelEdit = () => {
	commentIdBeingEdited.value = null;
	commentForm.reset(); 
	commentBeingEdited.value = null; 	
};

let addComment = () => {
	
	commentForm.post(route('posts.comments.store', props.post.id),{
		onSuccess: () => commentForm.reset('body'),
		preserveScroll: true	
	});
};

let updateComment = () => {
	commentForm.patch(route('comments.update',{
		comment: commentIdBeingEdited.value,
		page: props.comments.meta.current_page
	}), {
		onSuccess: () => cancelEdit(),
		preserveScroll: true
	});
}

let { confirmation } = useConfirm();

let deleteComment = async (commentId) => {
	if(! await confirmation('Are you sure you want to delete the comment?')){
		return;
	}
	
	router.delete(route('comments.destroy',{
		comment: commentId, 
		page:  props.comments.data.length > 1 
		? props.comments.meta.current_page
		: Math.max(props.comments.meta.current_page - 1,1)
	}),
	{
		preserveScroll: true
	})
};

</script>