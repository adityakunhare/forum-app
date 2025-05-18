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
					<ul  class="text-left divide-y">
						<div v-for="comment in comments.data" :key="comment.id"
							class="px-2 py-4 my-2 hover:text-blue-800 ">
							<div class="flex items-center gap-2 mb-4">
								<span>
									<img 
										src="https://www.w3schools.com/w3images/avatar6.png"
										class="rounded-full h-6" 
									/>
								</span>
								<span class="font-bold text-sm"> {{ comment.user?.name }} </span>
								<span class="text-gray-600 text-xs">{{ relativeDate(comment.created_at) }} ago </span>
							</div>
							<div>
								<span class="text-gray-600"> {{ comment.body }}</span>
							</div>
						</div>
					</ul>
					<Pagination :meta="comments.meta"/>
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

import { relativeDate } from '@/Utilities/date.js';

let props = defineProps(['post', 'comments']);

</script>