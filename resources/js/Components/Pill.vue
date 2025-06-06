<template>
	<Link 
		:href="link"
		class="whitespace-nowrap rounded-xl border-indigo-600 text-sm border px-2 py-1 mt-8 hover:bg-indigo-600 cursor-pointer hover:text-indigo-50"
		:class="{'bg-indigo-600 text-indigo-50' : filled }"
	>
		<slot/>
	</Link>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
	link: {
		required: true
	},
	filled: {
		default: false
	}
})

</script>