<template>
	<AppLayout>
			<Container>
				<ul class="divide-y-2" >
					<li v-for="post in posts.data" :key="post.id" class="px-2 py-4 my-2 hover:text-blue-800 ">
						<Link :href="post.routes.show">
							<span class="font-bold text-lg ">
								{{ post.title }}
							</span>
							<post-meta-data :created_at="post.created_at" :user="post.user"/>
						</Link>
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
import { Link } from '@inertiajs/vue3';

defineProps({
	posts: Array,
});

</script>
