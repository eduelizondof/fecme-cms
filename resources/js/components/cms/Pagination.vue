<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    links: PaginationLink[];
    from?: number;
    to?: number;
    total?: number;
}

defineProps<Props>();
</script>

<template>
    <div class="flex items-center justify-between py-4">
        <div class="text-sm text-muted-foreground">
            <span v-if="from && to && total">
                Mostrando {{ from }} a {{ to }} de {{ total }} resultados
            </span>
        </div>
        <div class="flex items-center gap-1">
            <template v-for="(link, index) in links" :key="index">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                >
                    <Button
                        variant="outline"
                        size="sm"
                        :class="{ 'bg-primary text-primary-foreground': link.active }"
                    >
                        <ChevronLeft v-if="index === 0" class="h-4 w-4" />
                        <ChevronRight v-else-if="index === links.length - 1" class="h-4 w-4" />
                        <span v-else v-html="link.label" />
                    </Button>
                </Link>
                <Button
                    v-else
                    variant="outline"
                    size="sm"
                    disabled
                >
                    <ChevronLeft v-if="index === 0" class="h-4 w-4" />
                    <ChevronRight v-else-if="index === links.length - 1" class="h-4 w-4" />
                    <span v-else v-html="link.label" />
                </Button>
            </template>
        </div>
    </div>
</template>



