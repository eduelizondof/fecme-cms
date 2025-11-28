<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ judges: any }>();

const columns = [
    { key: 'name', label: 'Nombre' },
    { key: 'email', label: 'Email' },
    { key: 'city', label: 'Ciudad' },
    { key: 'license_type', label: 'Tipo de Licencia' },
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
    { title: 'Jueces', href: '/cms/judges' },
];
</script>

<template>
    <Head title="Jueces - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Jueces"
                :columns="columns"
                :data="judges.data"
                create-route="/cms/judges/create"
                edit-route="/cms/judges/:id/edit"
                create-label="Crear juez"
                @delete="openDeleteDialog"
            >
                <template #cell-license_type="{ value }">
                    <Badge variant="outline">{{ value || 'N/A' }}</Badge>
                </template>
                <template #cell-is_active="{ value }">
                    <Badge :variant="value ? 'default' : 'secondary'">
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination :links="judges.links" :from="judges.from" :to="judges.to" :total="judges.total" />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/judges/${selectedId}` : undefined"
                title="Eliminar juez"
                description="¿Estás seguro de que deseas eliminar este juez?"
            />
        </div>
    </AppLayout>
</template>

