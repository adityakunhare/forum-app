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
					<MarkdownEditor
						id="body" 
						class="w-full" 
						v-model="form.body"
					>
						<template #toolbar="{ editor }">
							<li v-if="!isInProduction()">
								<button 
									@click="() => autofill()"
									class="rounded-tl p-2 font-bold bg-gray-100 border hover:bg-gray-200 "
									type="button" 
									title="Autofill"
								>
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px" fill="currentColor"><path d="M20.4668 8.69379L20.7134 8.12811C21.1529 7.11947 21.9445 6.31641 22.9323 5.87708L23.6919 5.53922C24.1027 5.35653 24.1027 4.75881 23.6919 4.57612L22.9748 4.25714C21.9616 3.80651 21.1558 2.97373 20.7238 1.93083L20.4706 1.31953C20.2942 0.893489 19.7058 0.893489 19.5293 1.31953L19.2761 1.93083C18.8442 2.97373 18.0384 3.80651 17.0252 4.25714L16.308 4.57612C15.8973 4.75881 15.8973 5.35653 16.308 5.53922L17.0677 5.87708C18.0555 6.31641 18.8471 7.11947 19.2866 8.12811L19.5331 8.69379C19.7136 9.10792 20.2864 9.10792 20.4668 8.69379ZM2 4C2 3.44772 2.44772 3 3 3H14V5H4V19H20V11H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4ZM7 8H17V11H15V10H13V14H14.5V16H9.5V14H11V10H9V11H7V8Z"></path></svg>
								</button>
							</li>
						</template>
					</MarkdownEditor> 
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
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { isInProduction } from '@/Utilities/environment';

let form = useForm({
	title: '',
	body: ''	
});


let autofill = async () => {
	let response = await axios.get(route('local.autofill'));
	form.title = response.data.title;
	form.body = response.data.body;
};

let createPost = () => form.post(route('posts.store')); 

</script>