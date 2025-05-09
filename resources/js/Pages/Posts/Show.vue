<template>
	<AppLayout :title="post.title">
		<Container>
			<h1 class="text-2xl font-bold">{{ post.title }}</h1>
			<span class="block text-sm text-gray-600"> {{formatedDate}} ago by {{post.user.name}} </span>
			<article class="mt-6"> 
				<pre class="whitespace-pre-wrap font-sans">{{ post.body }} </pre>
			</article>
		</Container>
	</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import { formatDistance, parseISO } from 'date-fns';
import { computed } from 'vue';

let props = defineProps(['post']);
let formatedDate = computed(() => formatDistance(parseISO(props.post.created_at), new Date()));

</script>