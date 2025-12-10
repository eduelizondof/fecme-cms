<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import axios from 'axios';
import { FileText, Link as LinkIcon, Plus, Trash2, Upload } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

interface FormatItem {
    name: string;
    type: 'file' | 'link';
    url: string;
}

interface FormatsData {
    description: string;
    items: FormatItem[];
}

interface Props {
    modelValue?: FormatsData | null;
    label?: string;
    descriptionPlaceholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    label: '',
    descriptionPlaceholder: 'Es necesario presentar los siguientes formatos debidamente llenados para iniciar la solicitud',
});

const emit = defineEmits<{
    'update:modelValue': [value: FormatsData | null];
}>();

const formatsData = computed({
    get: () => props.modelValue || { description: '', items: [] },
    set: (value) => emit('update:modelValue', value),
});

const isUploading = ref<{ [key: number]: boolean }>({});
const uploadError = ref<{ [key: number]: string }>({});

const updateDescription = (value: string) => {
    formatsData.value = {
        ...formatsData.value,
        description: value,
    };
};

const addFormat = () => {
    formatsData.value = {
        ...formatsData.value,
        items: [
            ...formatsData.value.items,
            { name: '', type: 'file', url: '' },
        ],
    };
};

const removeFormat = (index: number) => {
    const newItems = [...formatsData.value.items];
    newItems.splice(index, 1);
    formatsData.value = {
        ...formatsData.value,
        items: newItems,
    };
};

const updateFormat = (index: number, field: keyof FormatItem, value: string) => {
    const newItems = [...formatsData.value.items];
    newItems[index] = {
        ...newItems[index],
        [field]: value,
    };
    formatsData.value = {
        ...formatsData.value,
        items: newItems,
    };
};

const handleFileUpload = async (event: Event, index: number) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (!file) return;

    isUploading.value[index] = true;
    uploadError.value[index] = '';

    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await axios.post('/cms/media', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        updateFormat(index, 'url', response.data.url);
        updateFormat(index, 'name', file.name);
    } catch (error: any) {
        uploadError.value[index] = error.response?.data?.message || 'Error al subir el archivo';
    } finally {
        isUploading.value[index] = false;
        target.value = '';
    }
};

const moveItem = (fromIndex: number, toIndex: number) => {
    if (toIndex < 0 || toIndex >= formatsData.value.items.length) return;
    const newItems = [...formatsData.value.items];
    const [movedItem] = newItems.splice(fromIndex, 1);
    newItems.splice(toIndex, 0, movedItem);
    formatsData.value = {
        ...formatsData.value,
        items: newItems,
    };
};
</script>

<template>
    <div class="space-y-4">
        <div v-if="label" class="flex items-center justify-between">
            <Label>{{ label }}</Label>
        </div>

        <div class="space-y-2">
            <Label for="formats-description">Descripción de la sección</Label>
            <Textarea
                id="formats-description"
                :model-value="formatsData.description"
                @update:model-value="updateDescription"
                :placeholder="descriptionPlaceholder"
                :rows="2"
            />
        </div>

        <div class="flex items-center justify-between">
            <Label>Formatos</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addFormat"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar formato
            </Button>
        </div>

        <div v-if="formatsData.items.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay formatos. Haz clic en "Agregar formato" para comenzar.
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(item, index) in formatsData.items"
                :key="index"
                class="p-4 border rounded-lg space-y-3 group"
            >
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2 flex-1">
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
                                :disabled="index === formatsData.items.length - 1"
                                @click="moveItem(index, index + 1)"
                            >
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <span class="text-xs text-muted-foreground w-6 text-center">{{ index + 1 }}</span>

                        <div class="flex-1 space-y-2">
                            <Input
                                :model-value="item.name"
                                @update:model-value="updateFormat(index, 'name', $event as string)"
                                placeholder="Nombre del formato (ej: Formato de solicitud)"
                                class="flex-1"
                            />
                        </div>
                    </div>

                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeFormat(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label>Tipo</Label>
                        <Select
                            :model-value="item.type"
                            @update:model-value="updateFormat(index, 'type', $event as string)"
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="file">
                                    <div class="flex items-center gap-2">
                                        <FileText class="h-4 w-4" />
                                        Archivo local
                                    </div>
                                </SelectItem>
                                <SelectItem value="link">
                                    <div class="flex items-center gap-2">
                                        <LinkIcon class="h-4 w-4" />
                                        Link externo
                                    </div>
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="space-y-2">
                        <Label>{{ item.type === 'file' ? 'Archivo' : 'URL' }}</Label>
                        <div v-if="item.type === 'file'" class="space-y-2">
                            <Input
                                type="file"
                                :disabled="isUploading[index]"
                                @change="handleFileUpload($event, index)"
                                accept=".pdf,.doc,.docx,.xls,.xlsx"
                                class="cursor-pointer"
                            />
                            <div v-if="item.url" class="flex items-center gap-2 text-sm text-muted-foreground">
                                <FileText class="h-4 w-4" />
                                <span class="truncate">{{ item.url }}</span>
                            </div>
                            <p v-if="uploadError[index]" class="text-xs text-destructive">
                                {{ uploadError[index] }}
                            </p>
                            <p v-if="isUploading[index]" class="text-xs text-muted-foreground">
                                Subiendo archivo...
                            </p>
                        </div>
                        <div v-else class="space-y-2">
                            <Input
                                :model-value="item.url"
                                @update:model-value="updateFormat(index, 'url', $event as string)"
                                placeholder="https://drive.google.com/..."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ formatsData.items.length }} formato(s)
        </p>
    </div>
</template>

