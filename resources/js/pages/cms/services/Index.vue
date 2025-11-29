<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Service {
    id: number;
    title: string;
    slug: string;
    type: string;
    is_active: boolean;
}

interface Props {
    services: {
        data: Service[];
        links: any[];
        from: number;
        to: number;
        total: number;
    };
}

const props = defineProps<Props>();

const columns = [
    { key: 'title', label: 'Título' },
    { key: 'slug', label: 'Slug' },
    { key: 'type', label: 'Tipo' },
    { key: 'is_active', label: 'Estado' },
];

const deleteDialog = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteDialog = (id: number) => {
    selectedId.value = id;
    deleteDialog.value = true;
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Servicios', href: '/cms/services' },
];
</script>

<template>
    <Head title="Servicios - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Servicios"
                :columns="columns"
                :data="services.data"
                create-route="/cms/services/create"
                edit-route="/cms/services/:id/edit"
                delete-route="/cms/services/:id"
                create-label="Crear servicio"
                @delete="openDeleteDialog"
            >
                <template #cell-type="{ value }">
                    <Badge variant="outline">{{ value || 'N/A' }}</Badge>
                </template>
                <template #cell-is_active="{ value }">
                    <Badge 
                        :variant="value ? 'default' : 'secondary'"
                        :class="value ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-red-500 text-white hover:bg-red-600'"
                    >
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination
                :links="services.links"
                :from="services.from"
                :to="services.to"
                :total="services.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/services/${selectedId}` : undefined"
                title="Eliminar servicio"
                description="¿Estás seguro de que deseas eliminar este servicio?"
            />
        </div>
    </AppLayout>
</template>

