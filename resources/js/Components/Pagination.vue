<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <Link preserve-state  preserve-scroll v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-vert focus:border-black focus:text-white"
                    :class="{ 'bg-green-400 text-black': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3';
    export default {
        props: {
            links: Array
        },
        components:{
            Link,
        }
    }
</script>
