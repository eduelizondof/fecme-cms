<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { Heading1, List, Plus, Trash2, Type } from 'lucide-vue-next';
import { computed } from 'vue';

interface ContentBlock {
    type: 'paragraph' | 'heading' | 'list';
    text?: string;
    level?: number;
    items?: string[];
}

interface Props {
    modelValue: ContentBlock[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Contenido',
});

const emit = defineEmits<{
    'update:modelValue': [value: ContentBlock[]];
}>();

const blocks = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addBlock = (type: ContentBlock['type']) => {
    const newBlock: ContentBlock = type === 'list' 
        ? { type, items: [''] }
        : type === 'heading'
        ? { type, level: 2, text: '' }
        : { type, text: '' };
    
    blocks.value = [...blocks.value, newBlock];
};

const removeBlock = (index: number) => {
    const newBlocks = [...blocks.value];
    newBlocks.splice(index, 1);
    blocks.value = newBlocks;
};

const updateBlock = (index: number, field: string, value: any) => {
    const newBlocks = [...blocks.value];
    newBlocks[index] = { ...newBlocks[index], [field]: value };
    blocks.value = newBlocks;
};

const addListItem = (blockIndex: number) => {
    const newBlocks = [...blocks.value];
    const block = newBlocks[blockIndex];
    if (block.items) {
        block.items = [...block.items, ''];
    }
    blocks.value = newBlocks;
};

const removeListItem = (blockIndex: number, itemIndex: number) => {
    const newBlocks = [...blocks.value];
    const block = newBlocks[blockIndex];
    if (block.items) {
        block.items = block.items.filter((_, i) => i !== itemIndex);
    }
    blocks.value = newBlocks;
};

const updateListItem = (blockIndex: number, itemIndex: number, value: string) => {
    const newBlocks = [...blocks.value];
    const block = newBlocks[blockIndex];
    if (block.items) {
        block.items = [...block.items];
        block.items[itemIndex] = value;
    }
    blocks.value = newBlocks;
};

const moveBlock = (fromIndex: number, toIndex: number) => {
    if (toIndex < 0 || toIndex >= blocks.value.length) return;
    const newBlocks = [...blocks.value];
    const [movedBlock] = newBlocks.splice(fromIndex, 1);
    newBlocks.splice(toIndex, 0, movedBlock);
    blocks.value = newBlocks;
};

const getTypeIcon = (type: string) => {
    switch (type) {
        case 'heading': return Heading1;
        case 'list': return List;
        default: return Type;
    }
};

const getTypeLabel = (type: string) => {
    switch (type) {
        case 'heading': return 'Título';
        case 'list': return 'Lista';
        default: return 'Párrafo';
    }
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label v-if="label" class="text-base font-medium">{{ label }}</Label>
            <div class="flex gap-2">
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="addBlock('paragraph')"
                    class="gap-1"
                >
                    <Type class="h-4 w-4" />
                    Párrafo
                </Button>
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="addBlock('heading')"
                    class="gap-1"
                >
                    <Heading1 class="h-4 w-4" />
                    Título
                </Button>
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="addBlock('list')"
                    class="gap-1"
                >
                    <List class="h-4 w-4" />
                    Lista
                </Button>
            </div>
        </div>

        <div v-if="blocks.length === 0" class="text-sm text-muted-foreground py-8 text-center border border-dashed rounded-lg bg-muted/30">
            <p class="mb-2">No hay contenido aún.</p>
            <p>Agrega párrafos, títulos o listas usando los botones de arriba.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(block, index) in blocks"
                :key="index"
                class="relative border rounded-lg p-4 bg-card"
            >
                <!-- Header del bloque -->
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col gap-0.5">
                            <button
                                type="button"
                                class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                                :disabled="index === 0"
                                @click="moveBlock(index, index - 1)"
                            >
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                                :disabled="index === blocks.length - 1"
                                @click="moveBlock(index, index + 1)"
                            >
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>
                        <component :is="getTypeIcon(block.type)" class="h-4 w-4 text-muted-foreground" />
                        <span class="text-sm font-medium">{{ getTypeLabel(block.type) }}</span>
                        <span class="text-xs text-muted-foreground">#{{ index + 1 }}</span>
                    </div>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeBlock(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <!-- Contenido del bloque -->
                <div class="space-y-3">
                    <!-- Párrafo -->
                    <div v-if="block.type === 'paragraph'">
                        <Textarea
                            :model-value="block.text || ''"
                            @update:model-value="updateBlock(index, 'text', $event)"
                            placeholder="Escribe el contenido del párrafo..."
                            :rows="3"
                        />
                    </div>

                    <!-- Título -->
                    <div v-else-if="block.type === 'heading'" class="space-y-3">
                        <div class="flex gap-3">
                            <div class="w-32">
                                <Label class="text-xs text-muted-foreground">Nivel</Label>
                                <Select
                                    :model-value="String(block.level || 2)"
                                    @update:model-value="updateBlock(index, 'level', Number($event))"
                                >
                                    <SelectTrigger class="mt-1">
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="1">H1 - Principal</SelectItem>
                                        <SelectItem value="2">H2 - Secundario</SelectItem>
                                        <SelectItem value="3">H3 - Terciario</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <div class="flex-1">
                                <Label class="text-xs text-muted-foreground">Texto del título</Label>
                                <Input
                                    :model-value="block.text || ''"
                                    @update:model-value="updateBlock(index, 'text', $event)"
                                    placeholder="Escribe el título..."
                                    class="mt-1"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Lista -->
                    <div v-else-if="block.type === 'list'" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <Label class="text-xs text-muted-foreground">Elementos de la lista</Label>
                            <Button
                                type="button"
                                variant="ghost"
                                size="sm"
                                @click="addListItem(index)"
                                class="h-7 gap-1"
                            >
                                <Plus class="h-3 w-3" />
                                Elemento
                            </Button>
                        </div>

                        <div v-if="!block.items || block.items.length === 0" class="text-sm text-muted-foreground py-2 text-center">
                            Agrega elementos a la lista
                        </div>

                        <div v-else class="space-y-2">
                            <div
                                v-for="(item, itemIndex) in block.items"
                                :key="itemIndex"
                                class="flex items-center gap-2"
                            >
                                <span class="text-muted-foreground">•</span>
                                <Input
                                    :model-value="item"
                                    @update:model-value="updateListItem(index, itemIndex, $event as string)"
                                    placeholder="Elemento de lista..."
                                    class="flex-1"
                                />
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="icon"
                                    class="h-8 w-8 text-muted-foreground hover:text-destructive"
                                    @click="removeListItem(index, itemIndex)"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ blocks.length }} bloque(s) de contenido
        </p>
    </div>
</template>

