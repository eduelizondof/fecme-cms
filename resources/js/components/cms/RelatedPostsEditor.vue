<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface RelatedPost {
    slug: string;
    title: string;
    image: string;
    date: string;
}

interface Props {
    modelValue: RelatedPost[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Artículos relacionados',
});

const emit = defineEmits<{
    'update:modelValue': [value: RelatedPost[]];
}>();

const posts = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addPost = () => {
    posts.value = [...posts.value, { slug: '', title: '', image: '', date: '' }];
};

const removePost = (index: number) => {
    const newPosts = [...posts.value];
    newPosts.splice(index, 1);
    posts.value = newPosts;
};

const updatePost = (index: number, field: keyof RelatedPost, value: string) => {
    const newPosts = [...posts.value];
    newPosts[index] = { ...newPosts[index], [field]: value };
    
    // Auto-generar slug desde el título si está vacío
    if (field === 'title' && !newPosts[index].slug) {
        newPosts[index].slug = value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }
    
    posts.value = newPosts;
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label v-if="label" class="text-base font-medium">{{ label }}</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addPost"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar artículo
            </Button>
        </div>

        <div v-if="posts.length === 0" class="text-sm text-muted-foreground py-8 text-center border border-dashed rounded-lg bg-muted/30">
            <p>No hay artículos relacionados.</p>
            <p class="text-xs mt-1">Agrega referencias a otros artículos del blog.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(post, index) in posts"
                :key="index"
                class="border rounded-lg p-4 bg-card"
            >
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <span class="text-sm font-medium">Artículo relacionado #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removePost(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-3">
                        <div class="space-y-2">
                            <Label class="text-sm">Título *</Label>
                            <Input
                                :model-value="post.title"
                                @update:model-value="updatePost(index, 'title', $event as string)"
                                placeholder="Título del artículo"
                            />
                        </div>
                        <div class="space-y-2">
                            <Label class="text-sm">Slug</Label>
                            <Input
                                :model-value="post.slug"
                                @update:model-value="updatePost(index, 'slug', $event as string)"
                                placeholder="url-del-articulo"
                            />
                            <p class="text-xs text-muted-foreground">Se genera automáticamente desde el título</p>
                        </div>
                        <div class="space-y-2">
                            <Label class="text-sm">Fecha</Label>
                            <Input
                                :model-value="post.date"
                                @update:model-value="updatePost(index, 'date', $event as string)"
                                placeholder="15 Ene 2025"
                            />
                        </div>
                    </div>
                    <div>
                        <ImagePicker
                            :model-value="post.image"
                            @update:model-value="updatePost(index, 'image', $event as string)"
                            label="Imagen"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ posts.length }} artículo(s) relacionado(s)
        </p>
    </div>
</template>

