<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ certificates: any }>();

const columns = [
    { key: 'registration_number', label: 'No. Registro' },
    { key: 'name', label: 'Nombre' },
    { key: 'breed', label: 'Raza' },
    { key: 'owner', label: 'Propietario' },
    { key: 'status', label: 'Estado' },
];

const deleteDialog = ref(false);
const selectedId = ref<number | null>(null);

const openDeleteDialog = (id: number) => {
    selectedId.value = id;
    deleteDialog.value = true;
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Certificados', href: '/cms/certificates' },
];
</script>

<template>
    <Head title="Certificados - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Certificados"
                :columns="columns"
                :data="certificates.data"
                create-route="/cms/certificates/create"
                edit-route="/cms/certificates/:id/edit"
                create-label="Crear certificado"
                @delete="openDeleteDialog"
            >
                <template #cell-status="{ value }">
                    <Badge :variant="value === 'VIGENTE' ? 'default' : 'secondary'">
                        {{ value }}
                    </Badge>
                </template>
            </DataTable>

            <Pagination
                :links="certificates.links"
                :from="certificates.from"
                :to="certificates.to"
                :total="certificates.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/certificates/${selectedId}` : undefined"
                title="Eliminar certificado"
                description="¿Estás seguro de que deseas eliminar este certificado?"
            />
        </div>
    </AppLayout>
</template>



