<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ schools: any }>();

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
    { title: 'Escuelas', href: '/cms/schools' },
];
</script>

<template>
    <Head title="Escuelas - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Escuelas / Clubs"
                :columns="columns"
                :data="schools.data"
                create-route="/cms/schools/create"
                edit-route="/cms/schools/:id/edit"
                create-label="Crear escuela"
                @delete="openDeleteDialog"
            >
                <template #cell-is_active="{ value }">
                    <Badge :variant="value ? 'default' : 'secondary'">
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination :links="schools.links" :from="schools.from" :to="schools.to" :total="schools.total" />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/schools/${selectedId}` : undefined"
                title="Eliminar escuela"
                description="¿Estás seguro de que deseas eliminar esta escuela?"
            />
        </div>
    </AppLayout>
</template>

