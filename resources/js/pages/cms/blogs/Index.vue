<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Blog {
    id: number;
    title: string;
    slug: string;
    author: string;
    date: string;
    is_active: boolean;
}

interface Props {
    blogs: {
        data: Blog[];
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
    { key: 'author', label: 'Autor' },
    { key: 'date', label: 'Fecha' },
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
    { title: 'Blog', href: '/cms/blogs' },
];
</script>

<template>
    <Head title="Blog - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Blog"
                :columns="columns"
                :data="blogs.data"
                create-route="/cms/blogs/create"
                edit-route="/cms/blogs/:id/edit"
                create-label="Crear artículo"
                @delete="openDeleteDialog"
            >
                <template #cell-is_active="{ value }">
                    <Badge :variant="value ? 'default' : 'secondary'">
                        {{ value ? 'Activo' : 'Inactivo' }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination
                :links="blogs.links"
                :from="blogs.from"
                :to="blogs.to"
                :total="blogs.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/blogs/${selectedId}` : undefined"
                title="Eliminar artículo"
                description="¿Estás seguro de que deseas eliminar este artículo? Esta acción no se puede deshacer."
            />
        </div>
    </AppLayout>
</template>

