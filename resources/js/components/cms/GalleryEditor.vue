<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface GalleryItem {
    image: string;
    title?: string;
    description?: string;
}

interface Props {
    modelValue: GalleryItem[] | string[];
    label?: string;
    /** Si es true, solo permite URLs simples sin título/descripción */
    simpleMode?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Galería',
    simpleMode: false,
});

const emit = defineEmits<{
    'update:modelValue': [value: GalleryItem[] | string[]];
}>();

// Normalizar datos: convertir strings a objetos si es necesario
const items = computed({
    get: () => {
        const val = props.modelValue || [];
        if (props.simpleMode) {
            return val as string[];
        }
        // Convertir strings a objetos si es necesario
        return (val as any[]).map(item => 
            typeof item === 'string' ? { image: item, title: '', description: '' } : item
        ) as GalleryItem[];
    },
    set: (value) => {
        if (props.simpleMode) {
            emit('update:modelValue', value as string[]);
        } else {
            emit('update:modelValue', value as GalleryItem[]);
        }
    },
});

const addItem = () => {
    if (props.simpleMode) {
        items.value = [...(items.value as string[]), ''];
    } else {
        items.value = [...(items.value as GalleryItem[]), { image: '', title: '', description: '' }];
    }
};

const removeItem = (index: number) => {
    const newItems = [...items.value];
    newItems.splice(index, 1);
    items.value = newItems;
};

const updateSimpleItem = (index: number, value: string) => {
    const newItems = [...items.value] as string[];
    newItems[index] = value;
    items.value = newItems;
};

const updateItem = (index: number, field: keyof GalleryItem, value: string) => {
    const newItems = [...items.value] as GalleryItem[];
    newItems[index] = { ...newItems[index], [field]: value };
    items.value = newItems;
};

const moveItem = (fromIndex: number, toIndex: number) => {
    if (toIndex < 0 || toIndex >= items.value.length) return;
    const newItems = [...items.value];
    const [movedItem] = newItems.splice(fromIndex, 1);
    newItems.splice(toIndex, 0, movedItem);
    items.value = newItems;
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
                @click="addItem"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar imagen
            </Button>
        </div>

        <div v-if="items.length === 0" class="text-sm text-muted-foreground py-8 text-center border border-dashed rounded-lg bg-muted/30">
            <p>No hay imágenes en la galería.</p>
            <p class="text-xs mt-1">Haz clic en "Agregar imagen" para comenzar.</p>
        </div>

        <!-- Modo simple: solo URLs -->
        <div v-else-if="simpleMode" class="space-y-2">
            <div
                v-for="(item, index) in (items as string[])"
                :key="index"
                class="flex items-center gap-2 group"
            >
                <div class="flex flex-col gap-0.5 opacity-50 group-hover:opacity-100">
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === 0"
                        @click="moveItem(index, index - 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === items.length - 1"
                        @click="moveItem(index, index + 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <span class="text-xs text-muted-foreground w-6 text-center">{{ index + 1 }}</span>

                <div class="flex-1">
                    <ImagePicker
                        :model-value="item"
                        @update:model-value="updateSimpleItem(index, $event as string)"
                        label=""
                    />
                </div>

                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    class="h-8 w-8 text-muted-foreground hover:text-destructive"
                    @click="removeItem(index)"
                >
                    <Trash2 class="h-4 w-4" />
                </Button>
            </div>
        </div>

        <!-- Modo completo: con título y descripción -->
        <div v-else class="space-y-4">
            <div
                v-for="(item, index) in (items as GalleryItem[])"
                :key="index"
                class="border rounded-lg p-4 bg-card"
            >
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col gap-0.5">
                            <button
                                type="button"
                                class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                                :disabled="index === 0"
                                @click="moveItem(index, index - 1)"
                            >
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                                :disabled="index === items.length - 1"
                                @click="moveItem(index, index + 1)"
                            >
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm font-medium">Imagen #{{ index + 1 }}</span>
                    </div>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeItem(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <ImagePicker
                            :model-value="item.image"
                            @update:model-value="updateItem(index, 'image', $event as string)"
                            label="Imagen"
                        />
                    </div>
                    <div class="space-y-3">
                        <div class="space-y-2">
                            <Label class="text-sm">Título (opcional)</Label>
                            <Input
                                :model-value="item.title || ''"
                                @update:model-value="updateItem(index, 'title', $event as string)"
                                placeholder="Título de la imagen"
                            />
                        </div>
                        <div class="space-y-2">
                            <Label class="text-sm">Descripción (opcional)</Label>
                            <Input
                                :model-value="item.description || ''"
                                @update:model-value="updateItem(index, 'description', $event as string)"
                                placeholder="Breve descripción"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ items.length }} imagen(es) en la galería
        </p>
    </div>
</template>



