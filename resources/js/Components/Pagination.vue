<template>
  <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 mt-6 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <Link :href="previousUrl" preserve-scroll class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</Link>
      <Link :href="nextUrl" preserve-scroll  class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</Link>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ meta.from }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ meta.to }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ meta.total }}</span>
          {{ ' ' }}
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
          <Link 
            v-for="link in meta.links"
            :href="link.url== null ? '#': link.url" 
            :only="only"
            :class="{
              'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.active,
              'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0 bg-white': !link.active
            }"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0 first-of-type:rounded-l-md last-of-type:rounded-l-md"
            v-html="link.label"
            preserve-scroll
          ></Link>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

let props = defineProps({
  meta: Object,
  only:  {
    type: Array,
    default: () => []
  }
});

let only = computed(() => props.only.length === 0 ? [] : [...props.only, 'jetstream']);
let previousUrl = computed(() => props.meta.links[0].url == null ? '#': props.meta.links[0].url  );
let nextUrl = computed(() => [...props.meta.links].reverse()[0].url == null ? '#': [...props.meta.links].reverse()[0].url);


</script>