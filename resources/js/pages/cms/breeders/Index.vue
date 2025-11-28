<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ breeders: any }>();

const columns = [
    { key: 'name', label: 'Nombre' },
    { key: 'slug', label: 'Slug' },
    { key: 'email', label: 'Email' },
    { key: 'member_since', label: 'Miembro desde' },
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
    { title: 'Criaderos', href: '/cms/breeders' },
];
</script>

<template>
    <Head title="Criaderos - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Criaderos"
                :columns="columns"
                :data="breeders.data"
                create-route="/cms/breeders/create"
                edit-route="/cms/breeders/:id/edit"
                create-label="Crear criadero"
                @delete="openDeleteDialog"
            >
                <template #cell-is_active="{ value }">
                    <Badge :variant="value ? 'default' : 'secondary'">
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination
                :links="breeders.links"
                :from="breeders.from"
                :to="breeders.to"
                :total="breeders.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/breeders/${selectedId}` : undefined"
                title="Eliminar criadero"
                description="¿Estás seguro de que deseas eliminar este criadero?"
            />
        </div>
    </AppLayout>
</template>

