<template>
	<AppLayout title="Create post">
		<Container>

			<h1 class="text-2xl font-bold">Create a post</h1>
			<form @submit.prevent="createPost" class="mt-6">
				<div>
					<TextInput 
						id="title" 
						class="w-full" 
						v-model="form.title" 
						placeholder="Give it a title"
					/>
					<InputError class="mt-1" :message="form.errors.title"/>
				</div>		
				<div class="mt-4">
					<TextArea 
						id="body" 
						class="w-full" 
						v-model="form.body" 
						rows="20"
					/>
					<InputError class="mt-1" :message="form.errors.body"/>
				</div>
				<div class="mt-3">
					<PrimaryButton>Create post</PrimaryButton>
				</div>
			</form>
		</Container>	
	</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

let form = useForm({
	title: '',
	body: ''	
});

let createPost = () => form.post(route('posts.store')); 

</script>