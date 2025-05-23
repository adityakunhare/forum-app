<template>
	<AppLayout :title="post.title">
		<Container>

			<!-- post section starts -->
			<h1 class="text-2xl font-bold">{{ post.title }}</h1>
			<post-meta-data :created_at="post.created_at" :user="post.user" />
			<article class="mt-6">
				<pre class="whitespace-pre-wrap font-sans">{{ post.body }} </pre>
			</article>

			<!-- Comment section start -->
			<div class=" w-full flex justify-center mt-8 border-t pt-8">
				<div class="max-w-screen-md" v-if="comments.data.length > 0">
					<h2 class="text-xl font-bold">Comments</h2>

					<form v-if="$page.props.auth.user" @submit.prevent="addComment" class="w-full mt-9">
						<div >
							<TextArea 
								class="w-full" 
								rows="3" 
								v-model="commentForm.body" 
								placeholder="Speak your mind..." 
							/>
							<InputError :message="commentForm.errors.body"/>
						</div>

						<div class="text-right">
							<PrimaryButton 
								type="submit" 
								class="mt-5 flex" 
								:disabled="commentForm.processing"
							>
								Add Comment
							</PrimaryButton>
						</div>
					</form>

					<ul class="text-left divide-y">
						<div v-for="comment in comments.data" :key="comment.id"
							class="px-2 py-4 my-2 hover:text-blue-800 ">
							<div class="flex items-center gap-2 mb-4">
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
										> 
											<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 stroke-gray-300 hover:stroke-gray-500"> <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" /> </svg>
										</button>
									</form>
								</span>
							</div>
							<div>
								<span class="text-gray-600 break-all"> {{ comment.body }}</span>
							</div>
						</div>
					</ul>
					<Pagination :meta="comments.meta" :only="['comments']" />
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
import TextArea from '@/Components/TextArea.vue';
import { relativeDate } from '@/Utilities/date.js';
import { useForm } from '@inertiajs/vue3';
import {router} from '@inertiajs/vue3';

let props = defineProps(['post', 'comments']);
let commentForm = useForm({
	body: '',
});

let addComment = () => {
	commentForm.post(route('posts.comments.store', props.post.id),{
		onSuccess: () => commentForm.reset('body'),
		preserveScroll: true	
	});
}

let deleteComment = (commentId) => {
	router.delete(route('comments.destroy',commentId),{
		preserveScroll: true
	})
}

</script>