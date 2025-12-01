<script setup lang="ts">
import DynamicStringList from '@/components/cms/DynamicStringList.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { computed } from 'vue';

interface About {
    title: string;
    content: string[];
}

interface Props {
    modelValue: About | null;
    label?: string;
    /** Si es true, usa textareas individuales en lugar de lista */
    useParagraphs?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Acerca de',
    useParagraphs: true,
});

const emit = defineEmits<{
    'update:modelValue': [value: About | null];
}>();

const about = computed({
    get: () => props.modelValue || {
        title: '',
        content: [],
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof About, value: any) => {
    emit('update:modelValue', { ...about.value, [field]: value });
};

// Para el modo párrafos, gestión individual
const addParagraph = () => {
    updateField('content', [...about.value.content, '']);
};

const removeParagraph = (index: number) => {
    const newContent = [...about.value.content];
    newContent.splice(index, 1);
    updateField('content', newContent);
};

const updateParagraph = (index: number, value: string) => {
    const newContent = [...about.value.content];
    newContent[index] = value;
    updateField('content', newContent);
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="space-y-2">
            <Label for="about_title" class="text-sm">Título de la sección</Label>
            <Input
                id="about_title"
                :model-value="about.title"
                @update:model-value="updateField('title', $event)"
                placeholder="Ej: Acerca de Nuestro Criadero"
            />
        </div>

        <!-- Modo párrafos con textareas -->
        <div v-if="useParagraphs" class="space-y-3">
            <div class="flex items-center justify-between">
                <Label class="text-sm">Párrafos de contenido</Label>
                <button
                    type="button"
                    class="text-sm text-primary hover:underline"
                    @click="addParagraph"
                >
                    + Agregar párrafo
                </button>
            </div>

            <div v-if="about.content.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
                No hay párrafos. Haz clic en "Agregar párrafo" para comenzar.
            </div>

            <div v-else class="space-y-3">
                <div
                    v-for="(paragraph, index) in about.content"
                    :key="index"
                    class="relative"
                >
                    <div class="flex items-start gap-2">
                        <span class="text-xs text-muted-foreground pt-3 w-6">{{ index + 1 }}.</span>
                        <div class="flex-1">
                            <Textarea
                                :model-value="paragraph"
                                @update:model-value="updateParagraph(index, $event as string)"
                                placeholder="Escribe el contenido del párrafo..."
                                :rows="3"
                            />
                        </div>
                        <button
                            type="button"
                            class="p-2 text-muted-foreground hover:text-destructive"
                            @click="removeParagraph(index)"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <p class="text-xs text-muted-foreground">
                {{ about.content.length }} párrafo(s)
            </p>
        </div>

        <!-- Modo lista simple -->
        <DynamicStringList
            v-else
            :model-value="about.content"
            @update:model-value="updateField('content', $event)"
            label="Contenido"
            placeholder="Agregar párrafo..."
            add-button-text="Agregar párrafo"
        />
    </div>
</template>


