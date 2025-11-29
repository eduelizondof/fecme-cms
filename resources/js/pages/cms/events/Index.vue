<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ events: any }>();

const columns = [
    { key: 'title', label: 'Título' },
    { key: 'type', label: 'Tipo' },
    { key: 'start_date', label: 'Fecha inicio' },
    { key: 'organizer', label: 'Organizador' },
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
    { title: 'Eventos', href: '/cms/events' },
];
</script>

<template>
    <Head title="Eventos - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Eventos"
                :columns="columns"
                :data="events.data"
                create-route="/cms/events/create"
                edit-route="/cms/events/:id/edit"
                delete-route="/cms/events"
                create-label="Crear evento"
                @delete="openDeleteDialog"
            >
                <template #cell-type="{ value }">
                    <Badge variant="outline">{{ value || 'N/A' }}</Badge>
                </template>
                <template #cell-is_active="{ value }">
                    <Badge :class="value ? 'bg-green-500 text-white border-green-600' : 'bg-red-500 text-white border-red-600'">
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination
                :links="events.links"
                :from="events.from"
                :to="events.to"
                :total="events.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/events/${selectedId}` : undefined"
                title="Eliminar evento"
                description="¿Estás seguro de que deseas eliminar este evento?"
            />
        </div>
    </AppLayout>
</template>

