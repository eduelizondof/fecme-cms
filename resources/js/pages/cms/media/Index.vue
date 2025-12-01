<script setup lang="ts">
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Image, Trash2, Upload } from 'lucide-vue-next';
import { ref } from 'vue';

interface Media {
    id: number;
    name: string;
    file_name: string;
    mime_type: string;
    url: string;
    size: number;
    created_at: string;
}

const props = defineProps<{
    media: {
        data: Media[];
        links: any[];
        from: number;
        to: number;
        total: number;
    };
}>();

const mediaList = ref<Media[]>(props.media.data);
const isUploading = ref(false);
const uploadError = ref('');
const deleteDialog = ref(false);
const selectedMedia = ref<Media | null>(null);

const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = target.files;
    if (!files?.length) return;

    isUploading.value = true;
    uploadError.value = '';

    for (const file of Array.from(files)) {
        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await axios.post('/cms/media', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            mediaList.value.unshift(response.data.media);
        } catch (error: any) {
            uploadError.value = error.response?.data?.message || 'Error al subir archivo';
        }
    }

    isUploading.value = false;
    target.value = '';
};

const openDeleteDialog = (media: Media) => {
    selectedMedia.value = media;
    deleteDialog.value = true;
};

const deleteMedia = async () => {
    if (!selectedMedia.value) return;
    
    try {
        await axios.delete(`/cms/media/${selectedMedia.value.id}`);
        mediaList.value = mediaList.value.filter(m => m.id !== selectedMedia.value?.id);
        deleteDialog.value = false;
        selectedMedia.value = null;
    } catch (error) {
        console.error('Error deleting media:', error);
    }
};

const formatSize = (bytes: number) => {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
};

const copyUrl = (url: string) => {
    navigator.clipboard.writeText(url);
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Media', href: '/cms/media' },
];
</script>

<template>
    <Head title="Media - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Biblioteca de Media</h2>
                <div class="flex items-center gap-4">
                    <Input
                        type="file"
                        accept="image/*"
                        multiple
                        :disabled="isUploading"
                        @change="handleFileUpload"
                        class="max-w-xs"
                    />
                    <Button :disabled="isUploading">
                        <Upload class="mr-2 h-4 w-4" />
                        {{ isUploading ? 'Subiendo...' : 'Subir' }}
                    </Button>
                </div>
            </div>

            <p v-if="uploadError" class="text-sm text-destructive">{{ uploadError }}</p>

            <div v-if="mediaList.length === 0" class="flex flex-col items-center justify-center py-12 text-muted-foreground">
                <Image class="h-16 w-16 mb-4" />
                <p>No hay archivos en la biblioteca</p>
                <p class="text-sm">Sube imágenes para comenzar</p>
            </div>

            <div v-else class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <Card v-for="item in mediaList" :key="item.id" class="overflow-hidden group">
                    <CardContent class="p-0 relative">
                        <img
                            :src="item.url"
                            :alt="item.name"
                            class="w-full aspect-square object-cover"
                        />
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <Button
                                variant="secondary"
                                size="sm"
                                @click="copyUrl(item.url)"
                            >
                                Copiar URL
                            </Button>
                            <Button
                                variant="destructive"
                                size="icon"
                                class="h-8 w-8"
                                @click="openDeleteDialog(item)"
                            >
                                <Trash2 class="h-4 w-4" />
                            </Button>
                        </div>
                        <div class="p-2 text-xs truncate">
                            <p class="font-medium truncate">{{ item.name }}</p>
                            <p class="text-muted-foreground">{{ formatSize(item.size) }}</p>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                title="Eliminar archivo"
                description="¿Estás seguro de que deseas eliminar este archivo? Esta acción no se puede deshacer."
                @confirm="deleteMedia"
            />
        </div>
    </AppLayout>
</template>


