<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import axios from 'axios';
import { ImagePlus, Link as LinkIcon, Upload, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Props {
    modelValue?: string;
    label?: string;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    label: 'Imagen',
    placeholder: 'URL de la imagen',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const isOpen = ref(false);
const urlInput = ref(props.modelValue || '');
const isUploading = ref(false);
const uploadError = ref('');
const mediaLibrary = ref<any[]>([]);
const isLoadingMedia = ref(false);

watch(() => props.modelValue, (newValue) => {
    urlInput.value = newValue || '';
});

const loadMediaLibrary = async () => {
    isLoadingMedia.value = true;
    try {
        const response = await axios.get('/cms/media?type=images&per_page=50');
        mediaLibrary.value = response.data.data || [];
    } catch (error) {
        console.error('Error loading media library:', error);
    } finally {
        isLoadingMedia.value = false;
    }
};

const handleUrlSubmit = () => {
    emit('update:modelValue', urlInput.value);
    isOpen.value = false;
};

const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (!file) return;

    isUploading.value = true;
    uploadError.value = '';

    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await axios.post('/cms/media', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        emit('update:modelValue', response.data.url);
        isOpen.value = false;
    } catch (error: any) {
        uploadError.value = error.response?.data?.message || 'Error al subir la imagen';
    } finally {
        isUploading.value = false;
    }
};

const selectFromLibrary = (media: any) => {
    emit('update:modelValue', media.url);
    isOpen.value = false;
};

const clearImage = () => {
    emit('update:modelValue', '');
    urlInput.value = '';
};

const onOpenChange = (open: boolean) => {
    isOpen.value = open;
    if (open) {
        loadMediaLibrary();
    }
};
</script>

<template>
    <div class="space-y-2">
        <Label v-if="label">{{ label }}</Label>
        
        <div class="flex items-start gap-4">
            <div 
                v-if="modelValue"
                class="relative w-32 h-32 rounded-lg overflow-hidden border bg-muted"
            >
                <img 
                    :src="modelValue" 
                    :alt="label"
                    class="w-full h-full object-cover"
                />
                <Button
                    variant="destructive"
                    size="icon"
                    class="absolute top-1 right-1 h-6 w-6"
                    @click="clearImage"
                >
                    <X class="h-3 w-3" />
                </Button>
            </div>

            <Dialog :open="isOpen" @update:open="onOpenChange">
                <DialogTrigger as-child>
                    <Button variant="outline" type="button">
                        <ImagePlus class="mr-2 h-4 w-4" />
                        {{ modelValue ? 'Cambiar imagen' : 'Seleccionar imagen' }}
                    </Button>
                </DialogTrigger>
                <DialogContent class="max-w-2xl">
                    <DialogHeader>
                        <DialogTitle>Seleccionar imagen</DialogTitle>
                    </DialogHeader>
                    
                    <Tabs default-value="url" class="w-full">
                        <TabsList class="grid w-full grid-cols-3">
                            <TabsTrigger value="url">
                                <LinkIcon class="mr-2 h-4 w-4" />
                                URL
                            </TabsTrigger>
                            <TabsTrigger value="upload">
                                <Upload class="mr-2 h-4 w-4" />
                                Subir
                            </TabsTrigger>
                            <TabsTrigger value="library">
                                <ImagePlus class="mr-2 h-4 w-4" />
                                Biblioteca
                            </TabsTrigger>
                        </TabsList>

                        <TabsContent value="url" class="space-y-4">
                            <div class="space-y-2">
                                <Label>URL de la imagen</Label>
                                <Input
                                    v-model="urlInput"
                                    :placeholder="placeholder"
                                />
                            </div>
                            <div v-if="urlInput" class="w-full h-48 rounded-lg overflow-hidden border bg-muted">
                                <img 
                                    :src="urlInput" 
                                    alt="Preview"
                                    class="w-full h-full object-contain"
                                />
                            </div>
                            <Button @click="handleUrlSubmit" class="w-full">
                                Usar esta URL
                            </Button>
                        </TabsContent>

                        <TabsContent value="upload" class="space-y-4">
                            <div class="space-y-2">
                                <Label>Subir archivo</Label>
                                <Input
                                    type="file"
                                    accept="image/*"
                                    :disabled="isUploading"
                                    @change="handleFileUpload"
                                />
                            </div>
                            <p v-if="uploadError" class="text-sm text-destructive">
                                {{ uploadError }}
                            </p>
                            <p v-if="isUploading" class="text-sm text-muted-foreground">
                                Subiendo imagen...
                            </p>
                        </TabsContent>

                        <TabsContent value="library" class="space-y-4">
                            <div v-if="isLoadingMedia" class="text-center py-8 text-muted-foreground">
                                Cargando biblioteca...
                            </div>
                            <div v-else-if="mediaLibrary.length === 0" class="text-center py-8 text-muted-foreground">
                                No hay imágenes en la biblioteca
                            </div>
                            <div v-else class="grid grid-cols-4 gap-4 max-h-[400px] overflow-y-auto">
                                <button
                                    v-for="media in mediaLibrary"
                                    :key="media.id"
                                    type="button"
                                    class="aspect-square rounded-lg overflow-hidden border hover:border-primary transition-colors"
                                    @click="selectFromLibrary(media)"
                                >
                                    <img 
                                        :src="media.url" 
                                        :alt="media.name"
                                        class="w-full h-full object-cover"
                                    />
                                </button>
                            </div>
                        </TabsContent>
                    </Tabs>
                </DialogContent>
            </Dialog>
        </div>

        <Input
            :model-value="modelValue"
            :placeholder="placeholder"
            class="mt-2"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </div>
</template>

