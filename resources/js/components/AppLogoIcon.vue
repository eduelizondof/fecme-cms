<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img 
        src="/img/logo.svg" 
        alt="FECME Logo"
        :class="className"
        class="h-full w-full object-contain"
    />
</template>
