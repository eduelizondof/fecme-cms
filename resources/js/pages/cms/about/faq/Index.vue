<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

interface FaqItem {
    id: number;
    question: string;
    answer: string;
    is_active: boolean;
    display_order: number;
}

interface Props {
    faqs: FaqItem[];
}

defineProps<Props>();

const columns = [
    { key: 'question', label: 'Pregunta' },
    { key: 'is_active', label: 'Estado' },
    { key: 'display_order', label: 'Orden' },
];

const deleteDialog = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteDialog = (id: number) => {
    selectedId.value = id;
    deleteDialog.value = true;
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Nosotros', href: '/cms/about' },
    { title: 'FAQ', href: '/cms/faq' },
];
</script>

<template>
    <Head title="FAQ - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Preguntas Frecuentes (FAQ)"
                :columns="columns"
                :data="faqs"
                create-route="/cms/faq/create"
                edit-route="/cms/faq/:id/edit"
                delete-route="/cms/faq/:id"
                create-label="Crear FAQ"
                @delete="openDeleteDialog"
            >
                <template #cell-question="{ value }">
                    <div class="max-w-md truncate" :title="value">
                        {{ value }}
                    </div>
                </template>
                <template #cell-is_active="{ value }">
                    <Badge 
                        :variant="value ? 'default' : 'secondary'"
                        :class="value ? 'bg-green-500 text-white hover:bg-green-600' : ''"
                    >
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/faq/${selectedId}` : undefined"
                title="Eliminar FAQ"
                description="¿Estás seguro de que deseas eliminar esta pregunta frecuente? Esta acción no se puede deshacer."
            />
        </div>
    </AppLayout>
</template>

