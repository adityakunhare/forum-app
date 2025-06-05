<template>
	<AppLayout>
			<Container>
				<div>
					<Link v-if="selectedTopic" class="text-indigo-500 hover:text-indigo-600" :href="route('posts.index')"> <b><</b> Back to all posts</Link>
					<PageHeading 
						v-text="selectedTopic ? selectedTopic.name : 'All Posts'"
					/>
					<p v-if="selectedTopic" class="text-sm text-gray-600"> {{ selectedTopic.description }}</p>
				</div>

				<ul class="divide-y-2 mt-4">
					<li v-for="post in posts.data" :key="post.id" class="px-2 py-4 my-2 hover:text-blue-800 flex justify-between ">
						<Link :href="post.routes.show">
							<span class="font-bold text-lg ">
								{{ post.title }}
							</span>
							<post-meta-data :created_at="post.created_at" :user="post.user"/>
						</Link>
						<div class="mt-4">
							<Link 
								:href="route('posts.index',{topic: post.topic.slug})"
								class="rounded-xl border-indigo-600 text-sm border px-2 py-1 mt-8 hover:text-indigo-600 cursor-pointer"
							>
								{{ post.topic.name }}	
							</Link>
						</div>
					</li>
				</ul>
				<Pagination :meta="posts.meta"/>
			</Container>
	</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import PostMetaData from '@/Components/PostMetaData.vue';
import PageHeading from '@/Components/PageHeading.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
	posts: Array,
	selectedTopic: Object 
});

</script>
