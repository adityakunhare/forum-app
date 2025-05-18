<template>
	<span class="block text-sm text-gray-600"> {{ relativeDate(created_at) }} ago by {{ user.name }} </span>
</template>

<script setup>
import { relativeDate } from '@/Utilities/date.js';

let props = defineProps([
	'created_at', 'user'
]);

</script>